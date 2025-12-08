<x-layouts.frontend title="Contact">
    <div class="container mx-auto px-6 space-y-24">
        <section class="max-w-4xl mx-auto text-center pt-12 space-y-8">
            <div
                class="flex items-center gap-2 px-4 py-2 rounded-full bg-[#036482]/10 border border-[#036482]/20 text-[#036482] text-xs font-bold uppercase tracking-wider mx-auto w-fit whitespace-nowrap">
                The Risk Partners You Can Trust
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                Contact Us
            </h1>
            <p class="text-xl text-slate-400 leadCan you ing-relaxed mb-8">Get in touch with us today and let us help you
                with all your inquiries and concerns</p>
        </section>

        <div class="grid lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
            <div class="space-y-8">
                <div class="glass-panel p-8 rounded-2xl border-white/10 bg-[#0f172a]/50">
                    <h3 class="text-2xl font-bold text-white mb-6">Get In Touch</h3>
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-[#036482]/10 flex items-center justify-center text-[#036482] border border-[#036482]/20 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-6 h-6"
                                    aria-hidden="true">
                                    <path
                                        d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                    </path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg mb-1">Mailing Address</h4>
                                <p class="text-slate-400 leading-relaxed">60B West Terra Cotta Ave 159 <br>Crystal Lake,
                                    IL 60014
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-[#036482]/10 flex items-center justify-center text-[#036482] border border-[#036482]/20 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone w-6 h-6"
                                    aria-hidden="true">
                                    <path
                                        d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg mb-1">Phone</h4>
                                <p class="text-slate-400 text-lg">(815) 345-3629</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-[#036482]/10 flex items-center justify-center text-[#036482] border border-[#036482]/20 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-6 h-6"
                                    aria-hidden="true">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg mb-1">Email</h4><a
                                    href="mailto:info@autorisknow.com"
                                    class="text-slate-400 hover:text-[#EC7700] transition-colors text-lg">info@autorisknow.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="glass-panel p-8 md:p-10 rounded-2xl border-white/10 bg-[#0f172a]/80">
                <h3 class="text-2xl font-bold text-white mb-6">Send a Message</h3>
                <livewire:contact-us-form />
            </div>
        </div>
    </div>
</x-layouts.frontend>
