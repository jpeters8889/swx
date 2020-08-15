<?php

namespace Tests\Feature;

use App\Events\MemberBookingCancelled;
use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberLookup;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class CancelBookingTest extends TestCase
{
    use RefreshDatabase;

    protected MemberLookup $lookup;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Event::fake([SessionCreated::class, MemberBookingCancelled::class]);
        Notification::fake();
        TestTime::freeze();

        factory(Group::class)->create(['name' => 'Test Group', 'user_id' => factory(User::class)->create(['name' => 'Jamie Peters'])]);
        factory(Session::class)->create(['group_id' => 1, 'start_at' => '11:30']);

        GroupSession::query()->create([
            'group_id' => 1,
            'session_id' => 1,
            'date' => Carbon::tomorrow(),
        ]);

        factory(Member::class)->create([
            'email' => 'jamie@jamie-peters.co.uk',
            'group_session_id' => 1
        ]);

        $this->lookup = MemberLookup::query()->create([
            'email' => 'jamie@jamie-peters.co.uk'
        ]);
    }

    /** @test */
    public function it_errors_if_we_try_to_access_the_page_with_an_invalid_key()
    {
        $this->delete('/lookup/foo/foo')->assertStatus(404);
    }

    /** @test */
    public function it_errors_if_we_access_the_page_with_an_expired_key()
    {
        TestTime::addMinutes($this->lookup::EXPIRY_MINUTES);

        $this->delete('/lookup/' . $this->lookup->key . '/foo')->assertStatus(404);
    }

    /** @test */
    public function it_errors_if_we_try_to_access_the_page_with_a_valid_key_but_invalid_id()
    {
        $this->delete('/lookup/' . $this->lookup->key . '/999')->assertStatus(404);
    }

    /** @test */
    public function it_returns_success_when_we_access_the_page_with_a_valid_key_and_id()
    {
        $this->delete('/lookup/' . $this->lookup->key . '/1')->assertStatus(200);
    }

    /** @test */
    public function it_errors_if_we_try_to_access_the_page_with_a_key_and_id_that_dont_match_the_user()
    {
        factory(Member::class)->create([
            'email' => 'foo@bar.com',
            'group_session_id' => 1
        ]);

        $this->delete('/lookup/' . $this->lookup->key . '/2')->assertStatus(404);
    }

    /** @test */
    public function it_deletes_the_member()
    {
        $this->assertNotEmpty(Member::all());

        $this->delete('/lookup/' . $this->lookup->key . '/1');

        $this->assertEmpty(Member::all());
    }

    /** @test */
    public function it_dispatches_a_booking_deleted_event()
    {
        $this->withoutExceptionHandling();
        $this->delete('/lookup/' . $this->lookup->key . '/1');

        Event::assertDispatched(MemberBookingCancelled::class, function(MemberBookingCancelled $event) {
            return $event->lookup()->is($this->lookup);
        });
    }
}
