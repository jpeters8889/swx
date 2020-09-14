<?php

namespace Tests\Feature;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberBooking;
use App\Models\Session;
use App\Models\User;
use App\Notifications\SessionFullyBookedNotification;
use App\Notifications\SessionNearingCapacityNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class SessionFullyBookedNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake(SessionCreated::class);
        Notification::fake();

        factory(Group::class)->create(['name' => 'Test Group', 'user_id' => factory(User::class)->create(['name' => 'Jamie Peters'])]);
        factory(Session::class)->create(['group_id' => 1, 'start_at' => '11:30', 'seats' => 5]);

        GroupSession::query()->create([
            'group_id' => 1,
            'session_id' => 1,
            'date' => Carbon::parse('2020-08-01'),
        ]);

        factory(Member::class, 4)->create();
        Member::all()->each(static function(Member $member) {
            MemberBooking::query()->create(['group_session_id' => 1, 'member_id' => $member->id]);
        });
    }

    /** @test */
    public function it_doesnt_send_notifications_when_the_limit_isnt_met()
    {
        Notification::assertNotSentTo(User::query()->first(), SessionFullyBookedNotification::class);
    }

    /**
     * @test
     * @dataProvider notification_callbacks
     */
    public function it_dispatches_the_notification_when_the_group_is_nearing_limit($callback)
    {
        // The session currently has 4 out of 5 members, if we book a fourth
        // then the session is full

        $this->post("/test-group/1", [
            'name' => 'Foo Bar',
            'email' => 'jamie@jamie-peters.co.uk',
            'phone' => '123456',
            'requires_seat' => true
        ]);

        Notification::assertSentTo(
            User::query()->first(),
            SessionFullyBookedNotification::class,
            $callback
        );
    }

    public function notification_callbacks()
    {
        return [
            [null],

            // Group Session
            [static function (SessionFullyBookedNotification $notification, array $channels, User $user) {
                return $notification->groupSession->is(GroupSession::query()->first());
            }],

            // To
            [static function (SessionFullyBookedNotification $notification, array $channels, User $user) {
                return $user->is(Group::query()->first()->user);
            }],

            // Mail Channel
            [static function (SessionFullyBookedNotification $notification, array $channels, User $user) {
                return $channels === ['mail'];
            }],

            // From Name
            [static function (SessionFullyBookedNotification $notification, array $channels, User $user) {
                return $notification->toMail($user)->from[1] === $notification->groupSession->group->name;
            }],

            // Subject Line
            [static function (SessionFullyBookedNotification $notification, array $channels, User $user) {
                return $notification->toMail($user)->subject === 'Session Fully Booked';
            }],

            // Greeting Line
            [static function (SessionFullyBookedNotification $notification, array $channels, User $user) {
                return $notification->toMail($user)->greeting === 'Session Fully Booked';
            }],

            // Message Content
            [static function (SessionFullyBookedNotification $notification, array $channels, User $user) {
                /** @var GroupSession $groupSession */
                $groupSession = GroupSession::query()->first();
                $message = $notification->toMail($user)->introLines;

                $assertions = [
                    Str::contains($message[0], $groupSession->group->name),
                    Str::contains($message[0], $groupSession->date->format('l jS F Y')),
                    Str::contains($message[0], $groupSession->session->human_start_time),
                ];

                return !in_array(false, $assertions, true);
            }],
        ];
    }
}
