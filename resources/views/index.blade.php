@extends('layouts.slimming-world')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:flex-wrap">
        @foreach($groups as $group)
            <a class="flex flex-col border border-sw-red rounded p-3 my-2 sm:w-48" href="/{{ $group->slug }}">
                <h3 class="text-center text-lg leading-none mb-1">{{ $group->name }}</h3>
                <h4 class="text-sm text-center text-grey-dark leading-none">
                    with <span class="font-semibold">{{ $group->user->first_name }}</span></h4>

                <div class="flex flex-col mt-4">
                    @foreach($group->session_list as $day => $sessions)
                        <div>
                            <strong class="font-semibold">{{ $day }}</strong> - <em>{{ implode(', ', $sessions) }}</em>
                        </div>
                    @endforeach
                </div>

                <span class="text-xs mt-2">* denotes a new member session only.</span>
            </a>
        @endforeach
    </div>
@endsection
