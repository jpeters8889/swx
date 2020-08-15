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
use App\Notifications\BookingCancelledNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class BookingCancelledNotificationTest extends TestCase
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
            'group_session_id' => 1,
            'email' => 'jamie@jamie-peters.co.uk',
        ]);

        $lookup = MemberLookup::query()->create(['email' => 'jamie@jamie-peters.co.uk']);

        $this->delete("/lookup/{$lookup->key}/1");
    }

    /**
     * @test
     * @dataProvider notification_callbacks
     */
    public function it_dispatches_the_notification($callback)
    {
        Notification::assertSentTo(
            MemberLookup::query()->first(),
            BookingCancelledNotification::class,
            $callback
        );
    }


    public function notification_callbacks()
    {
        return [
            [null],

            // Mail Channel
            [static function (BookingCancelledNotification $notification, array $channels) {
                return $channels === ['mail'];
            }],

            // From Name
            [static function (BookingCancelledNotification $notification) {
                return $notification->toMail()->from[1] === Group::first()->name;
            }],

            // Notification Level
            [static function (BookingCancelledNotification $notification) {
                return $notification->toMail()->level === 'success';
            }],

            // Subject Line
            [static function (BookingCancelledNotification $notification) {
                return $notification->toMail()->subject === 'Slimming World Booking Cancelled';
            }],

            // Greeting Line
            [static function (BookingCancelledNotification $notification) {
                return $notification->toMail()->greeting === 'Booking Cancelled';
            }],

            // Message Content
            [static function (BookingCancelledNotification $notification) {
                $groupSession = GroupSession::first();

                $message = $notification->toMail()->introLines;

                $assertions = [
                    Str::contains($message[0], $groupSession->group->name),
                    Str::contains($message[0], $groupSession->group->user->first_name),
                    Str::contains($message[0], $groupSession->date->format('l jS F Y')),
                    Str::contains($message[0], $groupSession->session->human_start_time),
                    $message[1] === "Thanks, {$groupSession->group->user->first_name}",
                ];

                return !in_array(false, $assertions, true);
            }],
        ];
    }
}
