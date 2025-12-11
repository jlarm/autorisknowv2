<x-layouts.frontend title="Ridgeback Network Defense - Continuous Monitoring for FTC Safeguards Rule Compliance | ARMP"
    description="Ridgeback Network Defense provides 24/7/365 continuous monitoring of dealership technical infrastructure. Purpose-built appliance for vulnerability scanning,
  penetration testing, dark web monitoring, and FTC Safeguards Rule compliance without disrupting operations."
    keywords="Ridgeback Network Defense, FTC Safeguards Rule continuous monitoring, dealership cyber security, vulnerability scanning, penetration testing automotive, dark web
  monitoring, network security appliance, automotive cybersecurity, dealership network monitoring, compliance reporting, asset management, threat intelligence"
    ogTitle="Ridgeback Network Defense - 24/7 Network Monitoring for Automotive Dealerships"
    ogDescription="The watchdog that never sleeps. Ridgeback is a purpose-built appliance providing continuous monitoring, vulnerability scanning, penetration testing, and dark
  web monitoring to satisfy FTC Safeguards Rule requirements."
    ogImage="{{ asset('ridgeback-security.webp') }}"
    twitterTitle="Ridgeback Network Defense - Complete Visibility. Total Control."
    twitterDescription="24/7/365 continuous monitoring for automotive dealerships. Real-time scanning, automated reporting, and compliance made simple with Ridgeback Network
  Defense."
    canonicalUrl="{{ route('security') }}">
    <div class="container mx-auto px-6 space-y-24">
        <x-page-title-section title="Introducing Ridgeback Network Defense"
            subTitle="The ability to provide continuous monitoring of
                dealership technical infrastructure and all entry points. Ridgeback is the watchdog that never sleeps." />

        <div class="grid lg:grid-cols-2 gap-16 items-center mb-24">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Complete Visibility. <br>Total Control.</h2>
                <p class="text-slate-400 text-lg leading-relaxed mb-6">Modern dealerships are digital fortresses with
                    thousands of entry points. Ridgeback is a purpose-built appliance that sits on your network,
                    scanning for vulnerabilities 24/7/365.</p>
                <p class="text-slate-400 text-lg leading-relaxed mb-8">It satisfies the strict "Continuous Monitoring"
                    requirements of the FTC Safeguards Rule without disrupting your daily operations or slowing down
                    your network.</p>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-[#036482]/20 flex items-center justify-center text-[#036482] mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-activity w-5 h-5" aria-hidden="true">
                                <path
                                    d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg">Real-Time Scanning</h4>
                            <p class="text-slate-500 text-sm">Identifies open ports, unpatched software, and rogue
                                devices instantly.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-[#EC7700]/20 flex items-center justify-center text-[#EC7700] mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-text w-5 h-5" aria-hidden="true">
                                <path
                                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z">
                                </path>
                                <path d="M14 2v5a1 1 0 0 0 1 1h5"></path>
                                <path d="M10 9H8"></path>
                                <path d="M16 13H8"></path>
                                <path d="M16 17H8"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg">Automated Reporting</h4>
                            <p class="text-slate-500 text-sm">Generates executive summaries and technical remediation
                                plans automatically.</p>
                        </div>
                    </div>
                </div>
            </div>
            <x-ridgeback-screen />
        </div>

        <x-defense-table />

        <x-security-for />

        <x-dark-side-stories />
    </div>
</x-layouts.frontend>
