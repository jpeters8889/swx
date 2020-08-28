<?php

namespace Tests\Feature;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\Session;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Mockery\Matcher\Not;
use Tests\TestCase;

class BookingConfirmedNotificationTest extends TestCase
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
            'date' => Carbon::tomorrow(),
        ]);

        $this->withoutExceptionHandling();

        $this->post("/test-group/1", [
            'name' => 'Foo Bar',
            'email' => 'jamie@jamie-peters.co.uk',
            'phone' => '123456',
        ]);
    }

    /**
     * @test
     * @dataProvider notification_callbacks
     */
    public function it_dispatches_the_notification($callback)
    {
        Notification::assertSentTo(
            Member::query()->first(),
            BookingConfirmedNotification::class,
            $callback
        );
    }


    public function notification_callbacks()
    {
        return [
            [null],

            // Mail Channel
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                return $channels === ['mail'];
            }],

            // From Name
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                return $notification->toMail($member)->from[1] === $notification->groupSession->group->name;
            }],

            // Notification Level
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                return $notification->toMail($member)->level === 'success';
            }],

            // Subject Line
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                return $notification->toMail($member)->subject === 'Slimming World Booking Confirmed!';
            }],

            // Greeting Line
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                return $notification->toMail($member)->greeting === 'Booking Confirmed!';
            }],

            // Intro Lines
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                $introLines = $notification->toMail($member)->introLines;

                $assertions = [
                    Str::contains($introLines[0], $notification->groupSession->group->name),
                    Str::contains($introLines[0], $notification->groupSession->group->user->first_name),
                    Str::contains($introLines[0], $notification->groupSession->date->format('l jS F Y')),
                    Str::contains($introLines[0], $notification->groupSession->session->human_start_time),
//                    $message[1] === "Thanks, {$notification->groupSession->group->user->first_name}",
                    $introLines[1] === 'If you need to cancel your booking or view any of your previous bookings please use the link below.',
                ];

                return !in_array(false, $assertions, true);
            }],

            // Button
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                $button = [
                    'label' => $notification->toMail($member)->actionText,
                    'url' => $notification->toMail($member)->actionUrl,
                ];

                $assertions = [
                    $button['label'] => 'View Bookings',
                    $button['url'] => $member->lookups[0]->link()
                ];

                return !in_array(false, $assertions, true);
            }],

            // Outro Text
            [static function (BookingConfirmedNotification $notification, array $channels, Member $member) {
                $outroLines = $notification->toMail($member)->outroLines;

                return $outroLines[0] === "Thanks, {$notification->groupSession->group->user->first_name}";
            }],
        ];
    }
}
