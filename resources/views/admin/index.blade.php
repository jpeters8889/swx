@extends('layouts.slimming-world')

@section('content')
    <h3 class="text-center mb-4 text-lg">
        Consultant Admin
    </h3>

    <ul class="flex flex-col text-sw-red sm:flex-row sm:flex-wrap">
        <li class="p-4">
            <a class="flex flex-col items-center hover:text-sw-red-dark hover:underline" href="/admin/settings">
                <span>Settings</span>
            </a>
        </li>

        <li class="p-4">
            <a class="flex flex-col items-center hover:text-sw-red-dark hover:underline">
                <span>Groups</span>
            </a>
        </li>

        <li class="p-4">
            <a class="flex flex-col items-center hover:text-sw-red-dark hover:underline">
                <span>Payment Methods</span>
            </a>
        </li>

        <li class="p-4">
            <a class="flex flex-col items-center hover:text-sw-red-dark hover:underline">
                <span>Logout</span>
            </a>
        </li>
    </ul>
@endsection
