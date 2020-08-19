<?php

namespace App\Providers;

use App\Events\MemberBookedOntoSession;
use App\Events\MemberBookingCancelled;
use App\Events\MemberLookupCreated;
use App\Events\SessionCreated;
use App\Listeners\LogMemberCancellation;
use App\Listeners\SendBookingCancelledNotification;
use App\Listeners\CheckSessionCapacities;
use App\Listeners\CreateInitialGroupSessions;
use App\Listeners\SendBookingConfirmation;
use App\Listeners\SendMemberLookupNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SessionCreated::class => [
            CreateInitialGroupSessions::class,
        ],

        MemberBookedOntoSession::class => [
            SendBookingConfirmation::class,
            CheckSessionCapacities::class,
        ],

        MemberLookupCreated::class => [
            SendMemberLookupNotification::class,
        ],

        MemberBookingCancelled::class => [
            SendBookingCancelledNotification::class,
            LogMemberCancellation::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
