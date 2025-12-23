@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'ogTitle' => null,
    'ogDescription' => null,
    'ogImage' => null,
    'twitterCard' => 'summary_large_image',
    'twitterTitle' => null,
    'twitterDescription' => null,
    'twitterImage' => null,
    'canonicalUrl' => null,
    'noIndex' => false,
    'noFollow' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <title>Automotive Risk Management Partners</title>
    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://cdn.usefathom.com/script.js" data-site="DOKFHMYT" defer></script>
    <x-turnstile.scripts />
    <!-- / Fathom -->
    @include('partials.head', [
        'title' => $title,
        'description' => $description,
        'keywords' => $keywords,
        'ogTitle' => $ogTitle,
        'ogDescription' => $ogDescription,
        'ogImage' => $ogImage,
        'twitterCard' => $twitterCard,
        'twitterTitle' => $twitterTitle,
        'twitterDescription' => $twitterDescription,
        'twitterImage' => $twitterImage,
        'canonicalUrl' => $canonicalUrl,
        'noIndex' => $noIndex,
        'noFollow' => $noFollow,
    ])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617;
            /* Slate 950/Black */
            color: #e2e8f0;
            /* Slate 200 */
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* Noise Background Effect */
        .bg-noise {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 1;
            opacity: 0.04;
            /* Slightly lower opacity for subtlety */
            /* High frequency turbulence for fine grain, smaller background-size to prevent scaling up */
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            background-size: 96px 96px;
        }

        /* Organic Blob Animations */
        @keyframes floatOne {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(100px, 50px) scale(1.1);
            }

            66% {
                transform: translate(-50px, 100px) scale(0.95);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        @keyframes floatTwo {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(-80px, -60px) scale(1.1);
            }

            66% {
                transform: translate(60px, -30px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob-1 {
            animation: floatOne 25s infinite ease-in-out alternate;
        }

        .animate-blob-2 {
            animation: floatTwo 30s infinite ease-in-out alternate;
        }

        /* Dark Mode Glass Panel - refined for reference look */
        .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2), 0 8px 20px -6px rgba(0, 0, 0, 0.3);
        }

        .glass-panel:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(30, 41, 59, 0.7);
        }
    </style>
</head>

<body
    class="relative min-h-screen text-slate-400 font-sans selection:bg-[#EC7700]/30 selection:text-white bg-[#020617]">
    <div
        class="relative min-h-screen text-slate-300 selection:bg-cyan-500/30 selection:text-cyan-200 overflow-hidden bg-[#020617]">
        <x-frontend.background />

        <x-navigation />

        <div class="relative z-10 pt-24 pb-12 min-h-screen flex flex-col">
            {{ $slot }}
        </div>

        <x-frontend.footer />
    </div>
    @fluxScripts
</body>

</html>
