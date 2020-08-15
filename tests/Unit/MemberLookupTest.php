<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\Member;
use App\Models\MemberLookup;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class MemberLookupTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private MemberLookup $lookup;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->setUpFaker();

        TestTime::freeze();
        $this->lookup = MemberLookup::query()->create(['email' => $this->faker->email]);
    }

    /** @test */
    public function it_creates_a_uuid_when_creating_a_record()
    {
        $this->assertNotNull($this->lookup->key);
        $this->assertTrue(Str::isUuid($this->lookup->key));
    }

    /** @test */
    public function it_creates_a_valid_until_timestamp()
    {
        $this->assertNotNull($this->lookup->valid_until);
        $this->assertInstanceOf(Carbon::class, $this->lookup->valid_until);
    }

    /** @test */
    public function it_creates_a_valid_until_at_the_correct_time()
    {
        $this->assertTrue(
            TestTime::addMinutes(MemberLookup::EXPIRY_MINUTES)
                ->isSameAs(Carbon::DEFAULT_TO_STRING_FORMAT, $this->lookup->valid_until)
        );
    }

    /** @test */
    public function it_returns_true_when_the_lookup_is_still_valid()
    {
        $this->assertTrue($this->lookup->isValid());
        $this->assertFalse($this->lookup->hasExpired());

        TestTime::addMinutes(MemberLookup::EXPIRY_MINUTES - 1);

        $this->assertTrue($this->lookup->isValid());
        $this->assertFalse($this->lookup->hasExpired());
    }

    /** @test */
    public function it_returns_false_when_the_lookup_has_expired()
    {
        TestTime::addMinutes(MemberLookup::EXPIRY_MINUTES);

        $this->assertFalse($this->lookup->isValid());
        $this->assertTrue($this->lookup->hasExpired());
    }

    /** @test */
    public function it_is_linked_to_member_bookings()
    {
        factory(User::class)->create();
        factory(Group::class, 1)->create(['user_id' => 1]);
        factory(Session::class)->create(['group_id' => 1, 'advance_weeks_to_create' => 2]);

        factory(Member::class)->create(['email' => $this->lookup->email, 'group_session_id' => 1]);
        factory(Member::class)->create(['email' => $this->lookup->email, 'group_session_id' => 2]);
        factory(Member::class)->create(['group_session_id' => 1]);

        $this->assertCount(2, $this->lookup->fresh()->bookings);
    }

    /** @test */
    public function it_has_the_lookup_url()
    {
        $this->assertNotNull($this->lookup->link());

        $link = implode('/', [
           config('app.url'),
           'lookup',
           $this->lookup->key,
        ]);

        $this->assertEquals($link, $this->lookup->link());
    }
}