<footer class="relative z-10 border-t border-white/5 bg-[#020617] pt-16 pb-8 mt-auto">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl font-bold text-white">Automotive Risk Management Partners</span>
                </div>
                <p class="text-slate-500 text-sm max-w-sm leading-relaxed">
                    Simplicity, performance, and security, empowering you to navigate the dealership world with
                    confidence and agility.
                </p>
            </div>
            <div>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li>
                        <a href="{{ route('about') }}" wire:navigate class="hover:text-[#EC7700] transition-colors">About</a>
                    </li>
                    <li>
                        <a href="{{ route('solutions') }}" wire:navigate class="hover:text-[#EC7700] transition-colors">Solutions</a>
                    </li>
                    <li>
                        <a href="{{ route('security') }}" wire:navigate class="hover:text-[#EC7700] transition-colors">Security</a>
                    </li>
                    <li>
                        <a href="{{ route('packages') }}" wire:navigate class="hover:text-[#EC7700] transition-colors">Packages</a>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li>
                        <a href="{{ route('fi') }}" wire:navigate to="/about" class="hover:text-[#EC7700] transition-colors">F&I</a>
                    </li>
                    <li>
                        <a href="{{ route('videos') }}" wire:navigate to="/news" class="hover:text-[#EC7700] transition-colors">Videos</a>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}" wire:navigate to="/contact" class="hover:text-[#EC7700] transition-colors">News</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" wire:navigate to="/services" class="hover:text-[#EC7700] transition-colors">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-slate-600">
            <p>&copy; {{ now()->format('Y') }} Automotive Risk Management Partners</p>
            <div class="flex gap-6 mt-4 md:mt-0">
                <a href="{{ route('privacy') }}" wire:navigate class="hover:text-[#EC7700] transition-colors">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>
