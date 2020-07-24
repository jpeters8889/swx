<?php

namespace App\Providers;

use App\Events\MemberBookedOntoSession;
use App\Events\SessionCreated;
use App\Listeners\CheckSessionCapacities;
use App\Listeners\CreateInitialGroupSessions;
use App\Listeners\SendBookingConfirmation;
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
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
