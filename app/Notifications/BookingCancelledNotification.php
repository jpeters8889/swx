<?php

namespace App\Notifications;

use App\Models\GroupSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private GroupSession $groupSession;

    public function __construct(GroupSession $groupSession)
    {
        $this->groupSession = $groupSession;
    }

    public function toMail()
    {
        return (new MailMessage())
            ->from('notifications@sw-booking.co.uk', $this->groupSession->group->name)
            ->level('success')
            ->subject('Slimming World Booking Cancelled')
            ->greeting('Booking Cancelled')
            ->line("Your booking for the {$this->groupSession->group->name} Slimming World group with
            {$this->groupSession->group->user->first_name} on {$this->groupSession->date->format('l jS F Y')}
            at {$this->groupSession->session->human_start_time} has been cancelled.")
            ->line("Thanks, {$this->groupSession->group->user->first_name}");
    }

    public function via()
    {
        return ['mail'];
    }
}
