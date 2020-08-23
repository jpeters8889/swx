<?php

namespace Tests\Feature;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberBooking;
use App\Models\MemberLookup;
use App\Models\Session;
use App\Models\User;
use App\Notifications\BookingCancelledNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BookingDeletedEventTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake(SessionCreated::class);
        Notification::fake();

        factory(Group::class)->create(['name' => 'Test Group', 'user_id' => factory(User::class)->create(['name' => 'Jamie Peters'])]);
        factory(Session::class)->create(['group_id' => 1, 'start_at' => '11:30']);

        GroupSession::query()->create([
            'group_id' => 1,
            'session_id' => 1,
            'date' => Carbon::parse('2020-08-01'),
        ]);

        factory(Member::class)->create([
            'email' => 'jamie@jamie-peters.co.uk',
        ]);

        MemberBooking::query()->create(['member_id' => 1, 'group_session_id' => 1]);

        $lookup = MemberLookup::query()->create(['member_id' => 1]);

        $this->delete("/lookup/{$lookup->key}/1");
    }

    /** @test */
    public function it_generates_a_notification()
    {
        Notification::assertSentTo(Member::first(), BookingCancelledNotification::class);
    }

    /** @test */
    public function it_logs_the_deletion_in_the_database()
    {
        $this->assertNotEmpty(MemberLookup::all());

        $this->assertNotEmpty(GroupSession::query()->first()->cancellations);
        $this->assertEquals(MemberLookup::first()->member_id, 1);
    }
}
