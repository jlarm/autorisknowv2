<x-layouts.frontend title="F&I Profits - Higher Finance & Insurance Profits Immediately | ARMP"
    description="Discover how ARMP can help your automotive dealership achieve higher F&I profits immediately. Learn about our F&I compliance solutions, sales process
  optimization, and proven strategies to increase finance and insurance profitability."
    keywords="F&I profits, finance and insurance profits, dealership F&I, automotive finance profits, F&I compliance, F&I sales process, dealership profitability, finance office
   optimization, Red Flags Rule, OFAC compliance"
    ogTitle="Higher F&I Profits, Immediately - ARMP Solutions"
    ogDescription="Learn how ARMP helps automotive dealerships increase F&I profits immediately through compliance, process optimization, and proven sales strategies."
    ogImage="{{ asset('fi-profits.webp') }}" twitterTitle="Higher F&I Profits, Immediately"
    twitterDescription="Discover ARMP's proven strategies to increase your dealership's F&I profits while maintaining full compliance with regulations."
    canonicalUrl="{{ route('fi') }}">
    <div class="container mx-auto px-6 space-y-24">
        <x-page-title-section title="Higher F&I Profits, Immediately" />

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
                    { t: 'Retrieving Training Modules...', p: 70, d: 2800 },
                    { t: 'Decrypting Content Streams...', p: 90, d: 3800 },
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

        <div x-data="{ showContent: false }" x-show="showContent"
            @loading-complete.window="setTimeout(() => { showContent = true }, 700)"
            x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="space-y-8">
            {{-- First Video --}}
            <div class="relative rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                <div style="padding:56.25% 0 0 0;position:relative;">
                    {{-- Loader --}}
                    <div id="video-loader-1" class="absolute inset-0 flex items-center justify-center z-10">
                        <div class="flex flex-col items-center gap-4">
                            <flux:icon.arrow-path class="size-12 text-zinc-400 dark:text-zinc-500 animate-spin" />
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Loading video...</p>
                        </div>
                    </div>

                    {{-- Video --}}
                    <iframe id="video-1"
                        src="https://player.vimeo.com/video/1144534636?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;transition:opacity 0.3s ease-in-out;"
                        title="Higher F&amp;I Profits Immediately"></iframe>
                </div>
            </div>

            {{-- Second Video --}}
            <div class="relative rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                <div style="padding:56.25% 0 0 0;position:relative;">
                    {{-- Loader --}}
                    <div id="video-loader-2" class="absolute inset-0 flex items-center justify-center z-10">
                        <div class="flex flex-col items-center gap-4">
                            <flux:icon.arrow-path class="size-12 text-zinc-400 dark:text-zinc-500 animate-spin" />
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Loading video...</p>
                        </div>
                    </div>

                    {{-- Video --}}
                    <iframe id="video-2"
                        src="https://player.vimeo.com/video/1144535428?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;transition:opacity 0.3s ease-in-out;"
                        title="F-Network-Sales-Process-Video-8.1.24"></iframe>
                </div>
            </div>
        </div>

        {{-- Vimeo Player API Script --}}
        <script src="https://player.vimeo.com/api/player.js"></script>
        <script>
            let videosLoaded = {
                'video-1': false,
                'video-2': false
            };

            function checkAllVideosLoaded() {
                if (videosLoaded['video-1'] && videosLoaded['video-2']) {
                    window.dispatchEvent(new CustomEvent('videos-loaded'));
                }
            }

            function setupVideoLoader(videoId, loaderId) {
                const iframe = document.getElementById(videoId);
                const loader = document.getElementById(loaderId);

                if (!iframe || !loader) return;

                const player = new Vimeo.Player(iframe);

                player.ready().then(function() {
                    // Hide loader
                    loader.style.display = 'none';
                    // Show video with fade in
                    iframe.style.opacity = '1';
                    // Mark video as loaded
                    videosLoaded[videoId] = true;
                    checkAllVideosLoaded();
                }).catch(function(error) {
                    console.error('Error loading video:', error);
                    // Hide loader even on error
                    loader.style.display = 'none';
                    iframe.style.opacity = '1';
                    // Mark as loaded even on error so loading screen doesn't hang
                    videosLoaded[videoId] = true;
                    checkAllVideosLoaded();
                });
            }

            function initializeVideos() {
                // Reset loading state
                videosLoaded = {
                    'video-1': false,
                    'video-2': false
                };
                setupVideoLoader('video-1', 'video-loader-1');
                setupVideoLoader('video-2', 'video-loader-2');
            }

            // Handle both initial page load and Livewire navigation
            document.addEventListener('DOMContentLoaded', initializeVideos);
            document.addEventListener('livewire:navigated', initializeVideos);
        </script>
    </div>
</x-layouts.frontend>
