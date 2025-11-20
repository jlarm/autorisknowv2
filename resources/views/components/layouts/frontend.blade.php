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
            background-color: #f8fafc; /* Slate 50 */
            color: #0f172a; /* Slate 900 */
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Space Grotesk', sans-serif;
            color: #0f172a;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Noise Background Effect - Extremely subtle for light mode */
        .bg-noise {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 1;
            opacity: 0.3; /* Higher opacity but using mix-blend-overlay to be subtle on white */
            mix-blend-mode: overlay;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            background-size: 128px 128px;
        }

        /* Organic Blob Animations - Amplitude increased for visibility */
        @keyframes floatOne {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(200px, 100px) scale(1.2); }
            66% { transform: translate(-100px, 200px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        @keyframes floatTwo {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(-200px, -150px) scale(1.1); }
            66% { transform: translate(150px, -50px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .animate-blob-1 { animation: floatOne 25s infinite ease-in-out alternate; }
        .animate-blob-2 { animation: floatTwo 30s infinite ease-in-out alternate; }

        /* Light Mode Glass Panel */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8); /* Slate 200 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .glass-panel:hover {
            border-color: rgba(148, 163, 184, 0.4);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }
    </style>
</head>
<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="relative min-h-screen text-slate-600 font-sans selection:bg-[#036482]/20 selection:text-[#036482] overflow-hidden bg-slate-50">
        <div class="fixed inset-0 bg-slate-50 z-0"></div>
        <div class="fixed inset-0 overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full opacity-40 blur-[80px] animate-blob-1 mix-blend-multiply"
                style="background: radial-gradient(circle, #036482 0%, rgba(3,100,130,0) 70%)"
            ></div>

            <div
                class="absolute top-[5%] right-[-10%] w-[45vw] h-[45vw] rounded-full opacity-40 blur-[80px] animate-blob-2 mix-blend-multiply"
                style="background: radial-gradient(circle, #EC7700 0%, rgba(236,119,0,0) 70%); animationDelay: 2s"
            ></div>

            <div
                class="absolute bottom-[-20%] left-[20%] w-[60vw] h-[60vw] rounded-full opacity-30 blur-[100px] animate-blob-1 mix-blend-multiply"
                style="background: radial-gradient(circle, #036482 0%, rgba(3,100,130,0) 70%); animationDelay: -5s"
            ></div>
        </div>

        {/* 3. Noise Texture Overlay */}
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
