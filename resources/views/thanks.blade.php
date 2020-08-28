@extends('layouts.slimming-world')

@section('content')
    <p>
        Thank you, your booking was successful, we have sent you an email confirmation with
        the date and time of your group!
    </p>
    <h2 class="text-lg my-2 font-semibold text-sw-red">Booking Details</h2>
    <p>
        {{ $booking->groupSession->group->name }} with {{ $booking->groupSession->group->user->first_name }},
        on {{ $booking->groupSession->date->format('l jS F Y') }}
        at {{ $booking->groupSession->session->human_start_time }}.
    </p>
    <div class="mt-4 flex justify-center">
        <a class="bg-sw-red text-white leading-none py-4 px-6 rounded-lg text-lg font-semibold hover:bg-sw-red-80 transition-bg"
           href="/{{ $booking->groupSession->group->slug }}">
            Back to {{ $booking->groupSession->group->name }}
        </a>
    </div>
@endsection
