<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\MemberLookup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberLookupNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function toMail(MemberLookup $lookup)
    {
        return (new MailMessage())
            ->from('notifications@sw-booking.co.uk', 'Slimming World Bookings')
            ->level('success')
            ->subject('Your Slimming World Bookings')
            ->greeting('Your Slimming World Bookings')
            ->line('You have requested to view your previous Slimming World bookings, to view your bookings please click the link below.')
            ->action('View My Bookings', $lookup->link())
            ->line('This link will expire in ' . $lookup::EXPIRY_MINUTES . " minutes, if you didn't request a lookup you can safely ignore this email.")
            ->line('Thanks.');
    }

    public function via()
    {
        return ['mail'];
    }
}
