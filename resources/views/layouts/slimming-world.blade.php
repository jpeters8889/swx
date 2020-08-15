<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ mix('/assets/app.css') }}"/>

    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('page-view-builder::header')
</head>
<body class="mx-auto bg-grey-light flex">

<div class="w-full px-4 flex-1 flex flex-col max-w-modal mx-auto" id="app">
    <div class="bg-sw-red p-2 flex flex-col text-white font-semibold text-center sm:items-center">
        <h1 class="text-xl mb-2 sm:mb-0">Slimming World Booking</h1>
        <h2>Book Online</h2>
    </div>

    <div class="flex-flex w-full bg-white border-sw-red border-2 border-t-0 p-2">
        @yield('content')
    </div>

    <div class="bg-sw-red rounded-b">
        <member-lookup></member-lookup>
    </div>
</div>

<script src="{{ mix('/assets/manifest.js') }}" async defer></script>
<script src="{{ mix('/assets/vendor.js') }}" async defer></script>
<script src="{{ mix('/assets/app.js') }}" async defer></script>

</body>
</html>
