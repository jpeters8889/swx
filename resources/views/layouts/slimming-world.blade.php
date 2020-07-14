<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ mix('/assets/app.css') }}" />

    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cheshire Slimming World Groups</title>
</head>
<body class="mx-auto bg-grey-light flex">

    <div class="w-full px-4 flex-1 flex flex-col">
        <div class="bg-sw-red p-2 flex flex-col text-white font-semibold text-center sm:flex-row sm:text-left sm:justify-between sm:items-center">
            <h1 class="text-xl mb-2 sm:mb-0">Cheshire Slimming World Groups</h1>
            <h2>Pay Online</h2>
        </div>
        <div class="flex-flex w-full bg-white border-sw-red border-2 border-t-0 rounded-b p-2">
            <div id="app">
                @yield('content')
            </div>
        </div>
    </div>

<script src="{{ mix('/assets/manifest.js') }}"></script>
<script src="{{ mix('/assets/vendor.js') }}"></script>
<script src="{{ mix('/assets/app.js') }}"></script>

<script>
    app().build();
</script>
</body>
</html>
