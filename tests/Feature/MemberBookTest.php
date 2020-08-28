<?php

namespace Tests\Feature;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberBooking;
use App\Models\MemberLookup;
use App\Models\MemberLookupSource;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MemberBookTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected Group $group;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake(SessionCreated::class);
        Notification::fake();
        $this->setUpFaker();

        $this->group = factory(Group::class)->create(['user_id' => factory(User::class)->create()]);
        factory(Session::class)->create(['group_id' => 1]);

        GroupSession::query()->create([
            'group_id' => 1,
            'session_id' => 1,
            'date' => Carbon::today(),
        ]);
    }

    /** @test */
    public function it_errors_if_the_group_doesnt_exist()
    {
        $this->post('/foo/1')->assertStatus(404);
    }

    /** @test */
    public function it_errors_if_the_session_doesnt_belong_to_the_group()
    {
        $this->post("/{$this->group->slug}/123")->assertStatus(404);
    }

    /** @test */
    public function it_errors_if_there_isnt_a_name()
    {
        $this->makeRequest('', 'foo@foo.com', '123')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_there_isnt_an_email()
    {
        $this->withoutExceptionHandling();
        $this->makeRequest('foo', '', '123')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_there_isnt_a_phone()
    {
        $this->withoutExceptionHandling();
        $this->makeRequest('foo', 'foo@foo.com', '')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_the_session_is_full()
    {
        MemberBooking::query()->create(['member_id' => factory(Member::class)->create(), 'group_session_id' => 1]);
        Session::query()->first()->update(['capacity' => 1]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function it_adds_the_member_to_the_database()
    {
        $groupSession = GroupSession::query()->first();

        $this->assertEmpty($groupSession->members);

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456');

        $this->assertNotEmpty($groupSession->fresh()->bookings);

        $this->assertEquals('Jamie', Member::query()->first()->name);
        $this->assertEquals('jamie@jamie-peters.co.uk', Member::query()->first()->email);
        $this->assertEquals('123456', Member::query()->first()->phone);
    }

    /** @test */
    public function it_adds_a_row_to_the_member_lookup_table()
    {
        $this->assertEmpty(MemberLookup::all());

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456');

        $this->assertNotEmpty(MemberLookup::all());
        $this->assertNotEmpty(Member::query()->first()->lookups);
    }

    /** @test */
    public function it_creates_a_lookup_record_that_is_valid_until_the_group()
    {
        GroupSession::query()->first()->update(['date' => $date = Carbon::now()->addDays(2)]);

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456');

        $lookup = MemberLookup::query()->first();

        $this->assertTrue($date->endOfDay()->is($lookup->valid_until));
        $this->assertEquals(MemberLookupSource::FROM_BOOKING, $lookup->member_lookup_source_id);
    }

    /** @test */
    public function it_uses_an_already_created_member_when_the_data_matches()
    {
        factory(Member::class)->create([
            'name' => 'Jamie',
            'email' => 'jamie@jamie-peters.co.uk',
            'phone' => '123456',
        ]);

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456');

        $this->assertCount(1, Member::all());
        $this->assertEquals(1, MemberBooking::first()->member_id);
    }

    /** @test */
    public function it_stores_the_member_id_in_the_session()
    {
        $this->makeRequest()->assertSessionHas('booking_id', MemberBooking::query()->first()->id);
    }

    /** @test */
    public function it_errors_when_the_session_is_full()
    {
        $this->makeRequest();

        Session::query()->first()->update(['capacity' => 1]);

        $this->makeRequest()->assertStatus(422)->assertJson([
            'errors' => [
                'sessionFull' => 'No slots available in this session'
            ],
        ]);
    }

    /** @test */
    public function it_errors_when_the_member_is_already_booked_on_the_session()
    {
        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456');

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456')
            ->assertStatus(409)
            ->assertJson([
                'errors' => [
                    'conflict' => 'Member already exists on this session'
                ],
            ]);
    }

    /** @test */
    public function it_errors_when_a_member_is_already_booked_onto_a_session_on_the_same_day()
    {
        factory(Session::class)->create(['group_id' => 1, 'start_at' => '19:00']);

        GroupSession::query()->create([
            'group_id' => 1,
            'session_id' => 2,
            'date' => Carbon::today(),
        ]);

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456');

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456', 2)
            ->assertStatus(409)
            ->assertJson([
                'errors' => [
                    'sameday' => 'Member already booked onto a session on this day'
                ],
            ]);
    }

    /** @test */
    public function it_allows_a_member_to_book_onto_sessions_the_next_week()
    {
        factory(Session::class)->create(['group_id' => 1, 'start_at' => '19:00']);

        GroupSession::query()->create([
            'group_id' => 1,
            'session_id' => 2,
            'date' => Carbon::today()->addWeek(),
        ]);

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456')->assertStatus(200);

        $this->makeRequest('Jamie', 'jamie@jamie-peters.co.uk', '123456', 2)->assertStatus(200);
    }

    protected function makeRequest($name = null, $email = null, $phone = null, $sessionId = 1)
    {
        return $this->post("/{$this->group->slug}/{$sessionId}", [
            'name' => $name ?? $this->faker->name,
            'email' => $email ?? $this->faker->email,
            'phone' => $phone ?? $this->faker->phoneNumber,
        ]);
    }
}
