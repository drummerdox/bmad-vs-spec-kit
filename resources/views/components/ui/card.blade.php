@props(['padding' => 'md'])

@php
    $paddings = [
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'bg-surface-elevated rounded-2xl border border-gray-100 shadow-sm ' . ($paddings[$padding] ?? $paddings['md'])]) }}>
    {{ $slot }}
</div>
