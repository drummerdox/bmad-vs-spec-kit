@props([
    'title',
    'description' => null,
    'canonical' => null,
    'ogImage' => null,
    'robots' => null,
    'suffix' => true,
])

@php
    $appName = config('app.name', 'Todo App');
    $pageTitle = $suffix ? "{$title} — {$appName}" : $title;
    $canonicalUrl = $canonical ?? url()->current();
    $imageUrl = $ogImage ?? asset('og-image.png');
    $metaDescription = $description ?? 'Organize your daily tasks with a free, personal todo app built on the TALL stack.';
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
@if ($robots)
    <meta name="robots" content="{{ $robots }}">
@endif
<link rel="canonical" href="{{ $canonicalUrl }}">

<meta property="og:type" content="website">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:site_name" content="{{ $appName }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $imageUrl }}">
