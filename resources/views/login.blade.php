@extends('layouts.slimming-world')

@section('content')
    <h3 class="text-center mb-4 text-lg">
        Consultant Login
    </h3>

    <form method="post" action="/login">
        @csrf
        <div class="flex flex-col w-full max-w-login">
            <input class="w-full border-grey-off text-lg p-2 mb-2 border rounded" name="email" type="email" required
                   placeholder="Email Address"
                   value="{{ old('email') }}" />

            <input class="w-full border-grey-off text-lg p-2 mb-2 border rounded" name="password" type="password" required
                   placeholder="Password" />

            @if($errors->any())
                <span class="text-sw-red font-semibold mb-2">There was an error logging you in.</span>
            @endif

            <button type="submit" class="bg-sw-red rounded py-2 px-4 text-white hover:bg-sw-red-dark">
                Login
            </button>
        </div>
    </form>
@endsection
