<x-layouts.frontend title="Training Videos & Resources - Dealership Compliance Education | ARMP"
    description="Watch ARMP's educational videos covering automotive dealership compliance, cyber security training, OSHA safety, F&I best practices, and FTC Safeguards Rule
 requirements. Free training resources for dealership staff."
    keywords="dealership training videos, compliance training, automotive safety videos, FTC Safeguards training, OSHA training videos, F&I training, cyber security training,
 dealership education, compliance resources"
    ogTitle="Training Videos & Educational Resources for Automotive Dealerships"
    ogDescription="Access ARMP's library of training videos covering compliance, cyber security, OSHA safety, F&I best practices, and more. Educational resources to help your
 dealership stay compliant."
    ogImage="{{ asset('video-library.webp') }}" twitterTitle="ARMP Training Videos - Dealership Compliance Education"
    twitterDescription="Watch educational videos on dealership compliance, cyber security, OSHA, F&I, and FTC Safeguards Rule. Free training resources from ARMP."
    canonicalUrl="{{ route('videos') }}">
    <div class="container mx-auto px-6 space-y-24">
        <x-page-title-section title="Videos" subTitle="Check out our videos below to learn more." />

        {{-- Loading Screen --}}
        <div x-data="{
            text: 'Initializing Secure Connection...',
            progress: 0,
            isVisible: true,
            isComplete: false,
            timeouts: [],
            init() {
                const sequence = [
                    { t: 'Establishing Encrypted Tunnel...', p: 20, d: 800 },
                    { t: 'Verifying Dealer Credentials...', p: 45, d: 1800 },
                    { t: 'Retrieving Video Modules...', p: 70, d: 2800 },
                    { t: 'Loading Video Library...', p: 90, d: 3800 },
                    { t: 'Access Granted.', p: 100, d: 4500 },
                ];
        
                sequence.forEach(({ t, p, d }) => {
                    const timeoutId = setTimeout(() => {
                        if (!this.isComplete) {
                            this.text = t;
                            this.progress = p;
                        }
                    }, d);
                    this.timeouts.push(timeoutId);
                });
            },
            hideLoader() {
                this.isComplete = true;
                // Clear any pending timeouts
                this.timeouts.forEach(id => clearTimeout(id));
                this.text = 'Content Ready. Loading...';
                this.progress = 100;
                setTimeout(() => {
                    this.isVisible = false;
                    this.$dispatch('loading-complete');
                }, 800);
            }
        }" @videos-loaded.window="hideLoader()" x-show="isVisible"
            x-transition:leave="transition ease-in duration-700"
            x-transition:leave-start="opacity-100 scale-100 filter blur-0"
            x-transition:leave-end="opacity-0 scale-95 filter blur-sm"
            class="min-h-[60vh] flex flex-col items-center justify-center relative overflow-hidden bg-[#020617] rounded-3xl border border-white/5 mx-6">
            <div
                class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#036482]/10 blur-[100px] rounded-full pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col items-center w-full max-w-md">
                <div class="relative w-32 h-32 mb-10">
                    <div
                        class="absolute inset-0 border-2 border-dashed border-[#036482]/30 rounded-full animate-[spin_10s_linear_infinite]">
                    </div>
                    <div
                        class="absolute inset-2 border-2 border-t-transparent border-r-transparent border-[#036482] rounded-full animate-[spin_2s_linear_infinite]">
                    </div>
                    <div
                        class="absolute inset-6 border-2 border-b-transparent border-l-transparent border-[#EC7700] rounded-full animate-[spin_3s_linear_infinite_reverse]">
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg x-show="progress < 100" x-transition:enter="transition ease-in duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="absolute w-8 h-8 text-slate-500 animate-pulse">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <svg x-show="progress >= 100" x-transition:enter="transition ease-in duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" style="display: none;" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="absolute w-8 h-8 text-[#036482]">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 9.9-1" />
                        </svg>
                    </div>
                </div>

                <div class="font-mono text-[#036482] text-sm tracking-widest mb-4 h-6">
                    &gt; <span x-text="text.toUpperCase()"></span> <span class="animate-pulse">_</span>
                </div>

                <div class="w-full h-1 bg-[#1e293b] rounded-full overflow-hidden relative">
                    <div class="h-full bg-gradient-to-r from-[#036482] to-[#EC7700] transition-all duration-500 ease-out relative"
                        :style="`width: ${progress}%`">
                        <div class="absolute right-0 top-0 bottom-0 w-2 bg-white/50 blur-[2px]"></div>
                    </div>
                </div>

                <div class="w-full flex justify-between text-[10px] text-slate-600 font-mono mt-2">
                    <span>SECURE_SOCKET_LAYER</span>
                    <span x-text="`${progress}%`"></span>
                </div>
            </div>
        </div>

        {{-- Video Content --}}
        <div x-data="{ showContent: false }" x-show="showContent"
            @loading-complete.window="setTimeout(() => { showContent = true }, 700)"
            x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" style="display: none;">
            <livewire:frontend.video-index lazy />
        </div>

        <script>
            function initializeVideos() {
                // Wait for Livewire component to load and videos to appear
                const checkForVideos = setInterval(() => {
                    const iframes = document.querySelectorAll('iframe[src*="youtube.com"], iframe[src*="youtu.be"]');

                    if (iframes.length > 0) {
                        clearInterval(checkForVideos);

                        // Give videos a moment to start loading, then hide loader
                        setTimeout(() => {
                            window.dispatchEvent(new CustomEvent('videos-loaded'));
                        }, 1000);
                    }
                }, 100);

                // Timeout after 5 seconds if videos don't appear
                setTimeout(() => {
                    clearInterval(checkForVideos);
                    window.dispatchEvent(new CustomEvent('videos-loaded'));
                }, 5000);
            }

            // Handle both initial page load and Livewire navigation
            document.addEventListener('DOMContentLoaded', initializeVideos);
            document.addEventListener('livewire:navigated', initializeVideos);
        </script>
    </div>
</x-layouts.frontend>
