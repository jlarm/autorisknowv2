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
            background-color: #020617; /* Slate 950/Black */
            color: #e2e8f0; /* Slate 200 */
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
            opacity: 0.04; /* Slightly lower opacity for subtlety */
            /* High frequency turbulence for fine grain, smaller background-size to prevent scaling up */
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            background-size: 96px 96px;
        }

        /* Organic Blob Animations */
        @keyframes floatOne {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(100px, 50px) scale(1.1); }
            66% { transform: translate(-50px, 100px) scale(0.95); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        @keyframes floatTwo {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(-80px, -60px) scale(1.1); }
            66% { transform: translate(60px, -30px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .animate-blob-1 { animation: floatOne 25s infinite ease-in-out alternate; }
        .animate-blob-2 { animation: floatTwo 30s infinite ease-in-out alternate; }

        /* Dark Mode Glass Panel - refined for reference look */
        .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 1px rgba(0,0,0,0.2), 0 8px 20px -6px rgba(0,0,0,0.3);
        }

        .glass-panel:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(30, 41, 59, 0.7);
        }
    </style>
</head>
<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="relative min-h-screen text-slate-300 selection:bg-cyan-500/30 selection:text-cyan-200 overflow-hidden bg-[#020617]">
        <div class="fixed inset-0 bg-[#020617] z-0"></div>
        <div class="fixed inset-0 overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute top-[-20%] left-[50%] -translate-x-1/2 w-[80vw] h-[60vh] rounded-full opacity-20 blur-[120px]"
                style="background: radial-gradient(circle, rgba(34,211,238,1) 0%, rgba(2,6,23,0) 70%)"
            ></div>

            <div
                class="absolute top-[20%] right-[10%] w-[30vw] h-[30vw] rounded-full opacity-10 blur-[100px] animate-blob-2"
                style="background: radial-gradient(circle, rgba(96,165,250,1) 0%, rgba(2,6,23,0) 70%)"
            ></div>
        </div>
        <div class="bg-noise z-0"></div>

        <x-navigation />

        <div class="relative z-10 pt-24 pb-12 min-h-screen flex flex-col">
            {{ $slot }}
        </div>

        <x-frontend.footer />
    </div>
@fluxScripts
</body>
</html>
