<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function toMail(Member $member)
    {
        return (new MailMessage())
            ->from('notifications@sw-booking.co.uk', $member->groupSession->group->name)
            ->level('success')
            ->subject('Slimming World Booking Confirmed!')
            ->greeting('Booking Confirmed!')
            ->line("Your booking for the {$member->groupSession->group->name} Slimming World group with
            {$member->groupSession->group->user->first_name} on {$member->groupSession->date->format('l jS F Y')}
            at {$member->groupSession->session->human_start_time} has been confirmed!")
            ->line("Thanks, {$member->groupSession->group->user->first_name}");
    }

    public function via()
    {
        return ['mail'];
    }
}
