@extends('layouts.slimming-world')

@section('content')
    <p>
        Thank you, your booking was successful, we have sent you an email confirmation with
        the date and time of your group!
    </p>
    <h2 class="text-lg my-2">Booking Details</h2>
    <p>
        {{ $member->groupSession->group->name }} with {{ $member->groupSession->group->user->first_name }},
        on {{ $member->groupSession->date->format('l jS F Y') }} at {{ $member->groupSession->session->human_start_time }}.
    </p>
    <p class="mt-2">
        <a class="font-semibold hover:underline" href="/{{ $member->groupSession->group->slug }}">Back to group...</a>
    </p>
@endsection
