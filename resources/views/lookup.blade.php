@extends('layouts.slimming-world')

@section('content')
    <div class="flex flex-col">

        <p class="mb-2">
            On this page you can view and manage the groups you are booked onto, as well as view groups you have
            attended previously
        </p>

        <p class="mb-2">
            <a class="font-semibold text-sw-red hoer:underline" href="/">Back to Groups...</a>
        </p>

        <div class="border border-sw-red">
            <div class="bg-sw-red p-2">
                <h2 class="text-lg leading-none mb-1 text-white font-semibold">
                    Upcoming Bookings
                </h2>
            </div>

            <div>
                <ul>
                    @forelse($upcoming as $booking)
                        <li class="flex border-b border-sw-red">
                            <div class="flex-1 flex flex-col p-2">
                                <div class="mb-2 flex flex-col">
                                    <strong class="font-semibold">
                                        {{ $booking->groupSession->group->name }}
                                        with {{ $booking->groupSession->group->user->first_name }}
                                    </strong>
                                    {{ $booking->groupSession->date->format('D jS M') }},
                                    {{ $booking->groupSession->session->human_start_time }}
                                </div>
                                <div class="flex flex-col">
                                    <strong class="font-semibold">Booked Member Name</strong>
                                    {{ $member->name }}
                                </div>
                            </div>
                            <div class="p-2">
                                <cancel-session :id="{{ $booking->id }}" token="{{ $key }}"></cancel-session>
                            </div>
                        </li>
                    @empty
                        <li class="italic p-2">No upcoming bookings...</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="border border-sw-red">
            <div class="bg-sw-red p-2">
                <h2 class="text-lg leading-none mb-1 text-white font-semibold">
                    Previous Bookings
                </h2>
            </div>

            <div>
                <ul>
                    @forelse($past as $booking)
                        <li class="flex border-b border-sw-red">
                            <div class="mb-2 flex flex-col p-2">
                                <strong class="font-semibold">
                                    {{ $booking->groupSession->group->name }}
                                    with {{ $booking->groupSession->group->user->first_name }}
                                </strong>
                                {{ $booking->groupSession->date->format('D jS M') }},
                                {{ $booking->groupSession->session->human_start_time }}
                            </div>
                            <div class="flex flex-col">
                                <strong class="font-semibold">Booked Member Name</strong>
                                {{ $member->name }}
                            </div>
                        </li>
                    @empty
                        <li class="italic p-2">No previous bookings...</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
