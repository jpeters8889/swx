<?php

namespace Tests\Feature;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\Session;
use App\Models\User;
use App\Notifications\BookingConfirmed;
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
            'date' => Carbon::parse('2020-08-01'),
        ]);

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
            BookingConfirmed::class,
            $callback
        );
    }


    public function notification_callbacks()
    {
        return [
            [null],

            // Mail Channel
            [static function (BookingConfirmed $notification, array $channels, Member $member) {
                return $channels === ['mail'];
            }],

            // From Name
            [static function (BookingConfirmed $notification, array $channels, Member $member) {
                return $notification->toMail($member)->from[1] === $member->groupSession->group->name;
            }],

            // Notification Level
            [static function (BookingConfirmed $notification, array $channels, Member $member) {
                return $notification->toMail($member)->level === 'success';
            }],

            // Subject Line
            [static function (BookingConfirmed $notification, array $channels, Member $member) {
                return $notification->toMail($member)->subject === 'Slimming World Booking Confirmed!';
            }],

            // Greeting Line
            [static function (BookingConfirmed $notification, array $channels, Member $member) {
                return $notification->toMail($member)->greeting === 'Booking Confirmed!';
            }],

            // Message Content
            [static function (BookingConfirmed $notification, array $channels, Member $member) {
                $message = $notification->toMail($member)->introLines;

                $assertions = [
                    Str::contains($message[0], $member->groupSession->group->name),
                    Str::contains($message[0], $member->groupSession->group->user->first_name),
                    Str::contains($message[0], $member->groupSession->date->format('l jS F Y')),
                    Str::contains($message[0], $member->groupSession->session->human_start_time),
                    $message[1] === "Thanks, {$member->groupSession->group->user->first_name}",
                ];

                return !in_array(false, $assertions, true);
            }],
        ];
    }
}
