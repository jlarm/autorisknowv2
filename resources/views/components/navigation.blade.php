<div x-data="{
    isScrolled: window.scrollY > 50,
    mobileMenuOpen: false,
    ready: false
}" x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 50 });
$nextTick(() => { ready = true });">
    <header
        :class="[
            isScrolled || mobileMenuOpen ?
            'bg-[#020617]/80 backdrop-blur-xl border-white/5 py-3' :
            'bg-transparent border-transparent py-6',
            ready ? 'transition-all duration-500' : ''
        ]"
        class="fixed top-0 left-0 w-full z-40 border-b">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a wire:navigate href="{{ route('front') }}" class="-m-1.5 p-1.5">
                <span class="sr-only">Automotive Risk Management Partners</span>
                <img src="{{ asset('logo-white.svg') }}" alt="ARMP" class="h-8 w-auto" />
            </a>

            <nav class="hidden lg:flex items-center gap-8">
                <a wire:navigate href="{{ route('front') }}"
                    class="{{ request()->routeIs('front') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">Home</a>
                <a wire:navigate href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">About</a>
                <a wire:navigate href="{{ route('security') }}"
                    class="{{ request()->routeIs('security') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">Cyber Security</a>
                <a wire:navigate href="{{ route('packages') }}"
                    class="{{ request()->routeIs('packages') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">Packages</a>
                <a wire:navigate href="{{ route('fi') }}"
                    class="{{ request()->routeIs('fi') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">F&I</a>
                <a wire:navigate href="{{ route('videos') }}"
                    class="{{ request()->routeIs('videos') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">Videos</a>
                <a wire:navigate href="{{ route('news.index') }}"
                    class="{{ request()->routeIs('news.*') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">News</a>
                <a wire:navigate href="{{ route('contact') }}"
                    class="{{ request()->routeIs('contact') ? 'text-[#EC7700]' : 'text-slate-400' }} text-sm font-medium hover:text-[#EC7700] transition-all duration-300 relative group px-1 py-1 ">Contact</a>
            </nav>

            <button @click="mobileMenuOpen = !mobileMenuOpen" :aria-label="mobileMenuOpen ? 'Close menu' : 'Open menu'"
                aria-expanded="false" x-bind:aria-expanded="mobileMenuOpen.toString()"
                class="lg:hidden text-slate-300 hover:text-white transition-colors">
                <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu">
                    <path d="M4 5h16" />
                    <path d="M4 12h16" />
                    <path d="M4 19h16" />
                </svg>
                <svg x-cloak x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
    </header>

    <div x-show="mobileMenuOpen" x-cloak
        class="fixed inset-0 z-30 bg-[#020617]/95 backdrop-blur-xl pt-24 px-6 lg:hidden">
        <nav class="flex flex-col gap-6 text-lg">
            <a wire:navigate href="{{ route('front') }}"
                class="{{ request()->routeIs('front') ? 'text-cyan-400 font-semibold' : 'text-slate-400' }} border-b border-slate-800 pb-4 flex justify-between items-center">
                Home
                <svg class="w-5 h-5 opacity-50" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
            <a wire:navigate href="{{ route('videos') }}"
                class="{{ request()->routeIs('videos') ? 'text-cyan-400 font-semibold' : 'text-slate-400' }} border-b border-slate-800 pb-4 flex justify-between items-center">
                Videos
                <svg class="w-5 h-5 opacity-50" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
            <a wire:navigate href="{{ route('news.index') }}"
                class="{{ request()->routeIs('news') ? 'text-cyan-400 font-semibold' : 'text-slate-400' }} border-b border-slate-800 pb-4 flex justify-between items-center">
                News
                <svg class="w-5 h-5 opacity-50" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        </nav>
    </div>
</div>
