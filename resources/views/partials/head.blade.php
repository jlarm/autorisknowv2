<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

@if(!empty($description))
<meta name="description" content="{{ $description }}" />
@endif

@if(!empty($keywords))
<meta name="keywords" content="{{ is_array($keywords) ? implode(', ', $keywords) : $keywords }}" />
@endif

@php
    $robotsDirectives = [];
    if (!empty($noIndex)) $robotsDirectives[] = 'noindex';
    if (!empty($noFollow)) $robotsDirectives[] = 'nofollow';
@endphp
@if(count($robotsDirectives) > 0)
<meta name="robots" content="{{ implode(', ', $robotsDirectives) }}" />
@endif

@if(!empty($canonicalUrl))
<link rel="canonical" href="{{ $canonicalUrl }}" />
@endif

{{-- Open Graph Meta Tags --}}
@if(!empty($ogTitle))
<meta property="og:title" content="{{ $ogTitle }}" />
@endif
@if(!empty($ogDescription))
<meta property="og:description" content="{{ $ogDescription }}" />
@endif
@if(!empty($ogImage))
<meta property="og:image" content="{{ str_starts_with($ogImage, 'http') ? $ogImage : asset('storage/' . $ogImage) }}" />
@endif
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url()->current() }}" />

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="{{ $twitterCard ?? 'summary_large_image' }}" />
@if(!empty($twitterTitle))
<meta name="twitter:title" content="{{ $twitterTitle }}" />
@endif
@if(!empty($twitterDescription))
<meta name="twitter:description" content="{{ $twitterDescription }}" />
@endif
@if(!empty($twitterImage))
<meta name="twitter:image" content="{{ str_starts_with($twitterImage, 'http') ? $twitterImage : asset('storage/' . $twitterImage) }}" />
@endif

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
