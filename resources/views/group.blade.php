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
                    Click here to read an important update for groups from the 19th July.
                </template>

                <p class="mb-2">
                    Our groups are starting to slowly return to 'normal', but we still have lots of measures in place to
                    keep you safe at group.
                </p>

                <ul class="list-disc ml-4">
                    <li>
                        Masks aren't compulsory, but unless you are exempt we would ask that you wear a mask while
                        walking round the venue and at pay and weigh, but you can take it off when you're sat in your
                        seat for group.
                    </li>
                    <li>
                        Hand Sanitizer is available is available at several points around the venue, but feel free to
                        bring your own too if you like.
                    </li>
                    <li>
                        We will still be operating a separate entry/exit door, entry will be via the rear door and the
                        exit via the middle door straight onto the car park.
                    </li>
                    <li>
                        Shoes are no longer required when you are getting weighed, and we will be able to write in your
                        books again.
                    </li>
                    <li>
                        At the shop, if possible only touch what you are planning on buying.
                    </li>
                    <li>
                        All surfaces, and pay and weigh equipment will be cleaned between sessions.
                    </li>
                </ul>

                <ul>
                    <li>
                        We are removing the sneeze screens, social distance dots and one way system around the pay and
                        weigh stations.
                    </li>
                    <li>
                        For the time being our Tuesday morning group will be sticking at two shorter sessions.
                    </li>
                    <li>
                        Our Tuesday evening group will combine into one 90 minute session with 30 minute weigh period
                        and 60 minute IMAGE therapy group session.
                    </li>
                    <li>
                        Our Thursday evening groups will stay as two separate sessions at the same time, but be extended
                        into 90 minute sessions with a 30 minute weigh period and 60 minute IMAGE therapy group session.
                    </li>
                    <li>
                        New Member sessions will be at the same time as weigh at normal groups, rather than a dedicated
                        session between or after sessions.
                    </li>
                    <li>
                        Refreshments including tea and coffee will be available from the kitchen. Please wipe down after
                        use!
                    </li>
                    <li>
                        Toilets will be back open for use during groups.
                    </li>
                    <li>
                        Over the coming weeks we will slowly reintroduce previous group activities such as the raffle,
                        slimmer of the week basket, interest table.
                    </li>
                    <li>
                        Over the coming weeks we will start rearranging the group layout to how it was pre-covid with
                        the pay and weigh stations at the opposite end of the building to where they are now, and
                        introducing more seats and seats closer together.
                    </li>
                </ul>
            </accordion>

            @if($group->latestAnnouncement())
                <div class="bg-sw-green rounded p-3 font-semibold mt-2 text-white text-center">
                    <p>{{ $group->latestAnnouncement()->announcement }}</p>
                </div>
            @endif
        </div>

        <group-sessions :group-id="{{ $group->id }}" today="{{ $today }}" :now="{{ $now }}"></group-sessions>
    </div>
@endsection
