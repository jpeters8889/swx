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
            <div class="text-center text-sm mt-4">
                <a href="/" class="text-sw-red font-semibold hover:underline">Back to groups...</a>
            </div>
        </div>

        @foreach($dates as $date)
            <div class="flex flex-col border border-sw-red">
                <div class="bg-sw-red text-lg p-2 font-semibold text-white">
                    <h2>{{ $date[0]->date->format('l jS F') }}</h2>
                </div>

                <div class="flex flex-wrap m-1 leading-none">
                    @foreach($date as $groupSession)
                        <book-session
                            :group-session-id="{{ $groupSession->id }}"
                            group-slug="{{ $group->slug }}"
                            group-name="{{ $group->name }}"
                            group-date="{{ $date[0]->date->format('jS M') }}"
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
