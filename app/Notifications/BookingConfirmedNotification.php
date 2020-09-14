<?php

namespace App\Notifications;

use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberBooking;
use App\Models\MemberLookupSource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public GroupSession $groupSession;

    public function __construct(GroupSession $groupSession)
    {
        $this->groupSession = $groupSession;
    }

    public function toMail(Member $member)
    {
        $lookupUrl = $member->lookups()
            ->where('member_lookup_source_id', MemberLookupSource::FROM_BOOKING)
            ->latest()
            ->first()
            ->link();

        $groupName = $this->groupSession->group->name;

        if ($this->groupSession->session->weigh_only) {
            $groupName .= ' (Weigh Only Session)';
        }

        return (new MailMessage())
            ->from('notifications@sw-booking.co.uk', $this->groupSession->group->name)
            ->level('success')
            ->subject('Slimming World Booking Confirmed!')
            ->greeting('Booking Confirmed!')
            ->line("Your booking for the {$groupName} Slimming World group with
            {$this->groupSession->group->user->first_name} on {$this->groupSession->date->format('l jS F Y')}
            at {$this->groupSession->session->human_start_time} has been confirmed!")
            ->line('If you need to cancel your booking or view any of your previous bookings please use the link below.')
            ->action('View Bookings', $lookupUrl)
            ->line("Thanks, {$this->groupSession->group->user->first_name}");
    }

    public function via()
    {
        return ['mail'];
    }
}
