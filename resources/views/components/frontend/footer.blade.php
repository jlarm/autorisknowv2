<footer class="relative z-10 border-t border-white/5 bg-[#020617] pt-16 pb-8 mt-auto">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl font-bold text-white">Automotive Risk Management Partners</span>
                </div>
                <p class="text-slate-500 text-sm max-w-sm leading-relaxed">
                    Simplicity, performance, and security, empowering you to navigate the dealership world with confidence and agility.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Platform</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li><Link to="/services" class="hover:text-cyan-400 transition-colors">Infrastructure</Link></li>
                    <li><Link to="/security" class="hover:text-cyan-400 transition-colors">Security</Link></li>
                    <li><Link to="/services" class="hover:text-cyan-400 transition-colors">Audits</Link></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Company</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li><Link to="/about" class="hover:text-cyan-400 transition-colors">About Us</Link></li>
                    <li><Link to="/news" class="hover:text-cyan-400 transition-colors">Updates</Link></li>
                    <li><Link to="/contact" class="hover:text-cyan-400 transition-colors">Support</Link></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-slate-600">
            <p>&copy; {{ now()->format('Y') }} Automotive Risk Management Partners</p>
            <div class="flex gap-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
