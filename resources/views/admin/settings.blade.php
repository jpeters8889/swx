@extends('layouts.slimming-world')

@section('content')
    <h3 class="text-center mb-4 text-lg">
        Settings<br />
        <a class="text-sm" href="/admin">Back to Admin</a>
    </h3>

    <form>
        <div class="flex flex-col">
            <div class="flex flex-col">
                <div class="font-semibold">
                    <label for="page-name" class="text-sw-purple">Page Name</label><br />
                    <span class="text-xs leading-none">
                        This is the page your members will go to pay, eg
                        <span class="text-sw-purple">{{ config('app.url') }}/my-group</span>
                    </span>
                </div>
                <div>
                    <input id="page-name" name="page-name" class="w-full border-grey-off text-lg p-2 mb-2 border rounded"
                           maxlength="255" value="{{ old('page-name', $user->page_name) }}" />
                </div>
            </div>

            <!-- password? -->

            <!-- email? -->
        </div>
    </form>
@endsection
