@props(['seo' => null, 'title' => null, 'description' => null])

@php
    $metaTitle = $seo?->meta_title ?? ($title ?? config('app.name'));
    $metaDescription = $seo?->meta_description ?? ($description ?? '');
    $canonicalUrl = $seo?->canonical_url ?? url()->current();

    // Open Graph
    $ogTitle = $seo?->og_title ?? $metaTitle;
    $ogDescription = $seo?->og_description ?? $metaDescription;
    $ogImage = $seo?->og_image ?? null;

    // Twitter Card
    $twitterCard = $seo?->twitter_card ?? 'summary_large_image';
    $twitterTitle = $seo?->twitter_title ?? $ogTitle;
    $twitterDescription = $seo?->twitter_description ?? $ogDescription;
    $twitterImage = $seo?->twitter_image ?? $ogImage;
    $twitterSite = $seo?->twitter_site ?? config('services.twitter.site');
    $twitterCreator = $seo?->twitter_creator ?? config('services.twitter.creator');

    // Robots
    $noIndex = $seo?->no_index ?? false;
    $noFollow = $seo?->no_follow ?? false;
    $robotsContent = [];
    if ($noIndex) {
        $robotsContent[] = 'noindex';
    }
    if ($noFollow) {
        $robotsContent[] = 'nofollow';
    }
    $robots = count($robotsContent) > 0 ? implode(', ', $robotsContent) : 'index, follow';

    // Keywords
    $keywords = $seo?->keywords ?? [];
    $keywordsString = is_array($keywords) ? implode(', ', $keywords) : $keywords;
@endphp

{{-- Basic Meta Tags --}}
<title>{{ $metaTitle }}</title>
@if ($metaDescription)
    <meta name="description" content="{{ $metaDescription }}" />
@endif
@if ($keywordsString)
    <meta name="keywords" content="{{ $keywordsString }}" />
@endif
<meta name="robots" content="{{ $robots }}" />
<link rel="canonical" href="{{ $canonicalUrl }}" />

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $ogTitle }}" />
@if ($ogDescription)
    <meta property="og:description" content="{{ $ogDescription }}" />
@endif
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}" />
@endif
<meta property="og:site_name" content="{{ config('app.name') }}" />

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="{{ $twitterCard }}" />
<meta name="twitter:title" content="{{ $twitterTitle }}" />
@if ($twitterDescription)
    <meta name="twitter:description" content="{{ $twitterDescription }}" />
@endif
@if ($twitterImage)
    <meta name="twitter:image" content="{{ $twitterImage }}" />
@endif
@if ($twitterSite)
    <meta name="twitter:site" content="{{ $twitterSite }}" />
@endif
@if ($twitterCreator)
    <meta name="twitter:creator" content="{{ $twitterCreator }}" />
@endif
