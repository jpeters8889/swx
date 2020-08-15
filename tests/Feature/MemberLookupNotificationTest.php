<?php

namespace Tests\Feature;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberLookup;
use App\Models\Session;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification;
use App\Notifications\MemberLookupNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class MemberLookupNotificationTest extends TestCase
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
            'group_session_id' => 1
        ]);

        $this->post("/lookup", [
            'email' => 'jamie@jamie-peters.co.uk',
        ]);
    }

    /**
     * @test
     * @dataProvider notification_callbacks
     */
    public function it_dispatches_the_notification($callback)
    {
        Notification::assertSentTo(
            MemberLookup::query()->first(),
            MemberLookupNotification::class,
            $callback
        );
    }

    public function notification_callbacks()
    {
        return [
            [null],

            // Mail Channel
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                return $channels === ['mail'];
            }],

            // From Name
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                return $notification->toMail($lookup)->from[1] === 'Slimming World Bookings';
            }],

            // Notification Level
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                return $notification->toMail($lookup)->level === 'success';
            }],

            // Subject Line
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                return $notification->toMail($lookup)->subject === 'Your Slimming World Bookings';
            }],

            // Greeting Line
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                return $notification->toMail($lookup)->greeting === 'Your Slimming World Bookings';
            }],

            // First Line
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                return $notification->toMail($lookup)->introLines[0] === 'You have requested to view your previous Slimming World bookings, to view your bookings please click the link below.';
            }],

            // Outro Line
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                return $notification->toMail($lookup)->outroLines[0] === 'This link will expire in ' . $lookup::EXPIRY_MINUTES . " minutes, if you didn't request a lookup you can safely ignore this email.";
            }],

            // CTA Label
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                $message = $notification->toMail($lookup);

                return $message->actionText = 'View My Bookings';
            }],

            // CTA Url
            [static function (MemberLookupNotification $notification, array $channels, MemberLookup $lookup) {
                $message = $notification->toMail($lookup);

                return $message->actionUrl = $lookup->link();
            }],
        ];
    }
}
