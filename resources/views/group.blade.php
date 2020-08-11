@extends('layouts.slimming-world')

@section('content')
    <div class="flex flex-col space-y-2">
        <div class="flex justify-between items-bottom flex-col">
            <div class="text-center">
                <h2 class="text-lg leading-none mb-1">{{ $group->name }}</h2>
                <h3 class="text-sm text-center text-grey-dark leading-none">
                    with <strong class="font-semibold">{{ $group->user->first_name }}</strong>
                </h3>
            </div>

            <div class="text-center text-sm mt-4 mb-2">
                <a href="/" class="text-sw-red font-semibold hover:underline">Back to groups...</a>
            </div>

            <accordion>
                <template v-slot:title>
                    Click here to read the safety measures we have in place at our groups.
                </template>

                <p class="mb-2">
                    We've got lots of measures in place to keep you safe at group, including compulsory booking for all
                    attendees, other safety measures include:
                </p>

                <ul class="list-disc ml-4">
                    <li>
                        Hand Sanitizer is available at the pay station, weigh station and the shop, but feel free to
                        bring your own too if you like.
                    </li>
                    <li>
                        Masks are not compulsory in our groups, but feel free to wear one if you prefer.
                    </li>
                    <li>
                        There will be a one-way system in the venue and queueing outside the seating area.
                    </li>
                    <li>
                        We will be operating a separate entry/exit door where possible.
                    </li>
                    <li>
                        Sneeze screens will in place around the pay station, weigh station and shop to protected the
                        consultant and social team.
                    </li>
                    <li>
                        Please pay contactless where possible. If you need to pay by Chip and Pin we will provide a
                        single use glove for handling the terminal.
                    </li>
                    <li>
                        Cash will be accepted, but please use the correct change where possible.
                    </li>
                    <li>
                        Shoes <strong>MUST</strong> be worn on scales when you are weighing.
                    </li>
                    <li>
                        Please bring your own pen to write your weight in your book.
                    </li>
                    <li>
                        When weighed please take the first available seat and please do not move seat after sitting
                        down.
                    </li>
                    <li>
                        If you place your belongings on a seat before weighing you must sit in that seat.
                    <li>
                        Toilets are emergency only, so please go before attending group.
                    </li>
                    <li>
                        Any items that you handle from the shop, but do not purchase will be placed in a box for
                        decontamination.
                    </li>
                    <li>
                        There are no refreshments available, so please bring your own drinks if required.
                    </li>
                    <li>
                        Please wipe your seat before leaving the group, wipes will be provided.
                    </li>
                    <li>
                        There is no raffle or slimmer of the week basket at present.
                    </li>
                    <li>
                        All surfaces, and pay and weight equipment will be cleaned between sessions.
                    </li>
                </ul>
            </accordion>
        </div>

        @foreach($dates as $date)
            <div class="flex flex-col border border-sw-red">
                <div class="bg-sw-red text-lg p-2 font-semibold text-white">
                    <h2>{{ $date[0]->date->format('l jS F') }}</h2>
                </div>

                <div class="flex flex-wrap m-1 leading-none">
                    @foreach($date as $groupSession)
                        <book-session
                            today="{{ $today }}"
                            :now="{{ $now }}"
                            :group-session-id="{{ $groupSession->id }}"
                            group-slug="{{ $group->slug }}"
                            group-name="{{ $group->name }}"
                            group-date="{{ $date[0]->date->format('jS M') }}"
                            :session-start="{{ Carbon\Carbon::parse($groupSession->session->start_at)->format('Gi') }}"
                            :new-member="{{ $groupSession->session->new_member_session ? 'true' : 'false' }}"
                            :capacity="{{ $groupSession->session->capacity }}"
                            :capacity-threshold="{{ $groupSession->session->capacity_threshold }}"
                            :current-count="{{ $groupSession->members_count }}"
                        >
                            {{ $groupSession->session->human_start_time }}
                        </book-session>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
