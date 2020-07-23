@component('mail::message')
# {{ $greeting }}

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}


@endforeach

@endcomponent
