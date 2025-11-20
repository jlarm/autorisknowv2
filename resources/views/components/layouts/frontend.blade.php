<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
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
    </div>
@fluxScripts
</body>
</html>
