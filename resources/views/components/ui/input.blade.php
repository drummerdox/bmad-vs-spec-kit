@props(['disabled' => false, 'error' => false])

@php
    $classes = 'block w-full rounded-xl border shadow-sm motion-safe-transition focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed';
    $classes .= $error
        ? ' border-red-300 text-red-900 placeholder-red-300'
        : ' border-gray-200 text-ink placeholder-muted';
@endphp

<input @disabled($disabled) {{ $attributes->merge(['class' => $classes]) }}>
