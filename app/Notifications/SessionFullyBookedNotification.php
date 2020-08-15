<?php

namespace App\Notifications;

use App\Models\GroupSession;
use App\Models\Member;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionFullyBookedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public GroupSession $groupSession;

    public function __construct(GroupSession $groupSession)
    {
        $this->groupSession = $groupSession;
    }

    public function toMail(User $user)
    {
        return (new MailMessage())
            ->from('notifications@sw-booking.co.uk', $this->groupSession->group->name)
            ->subject('Session Fully Booked')
            ->greeting('Session Fully Booked')
            ->line("Your {$this->groupSession->group->name} group on {$this->groupSession->date->format('l jS F Y')}
            at {$this->groupSession->session->human_start_time} is fully booked.");
    }

    public function via()
    {
        return ['mail'];
    }
}
