@props(['fallback'])

@php
    $previousUrl = url()->previous();
    $backUrl = \Illuminate\Support\Str::startsWith($previousUrl, url('/')) ? $previousUrl : $fallback;
@endphp

<a href="{{ $backUrl }}" data-back-fallback="{{ $backUrl }}" {{ $attributes }}>
    {{ $slot }}
</a>
