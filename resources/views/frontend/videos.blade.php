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
        <section class="max-w-4xl mx-auto text-center pt-12 space-y-8">
            <div
                class="flex items-center gap-2 px-4 py-2 rounded-full bg-[#036482]/10 border border-[#036482]/20 text-[#036482] text-xs font-bold uppercase tracking-wider mx-auto w-fit whitespace-nowrap">
                The Risk Partners You Can Trust
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                Videos
            </h1>
            <p class="text-xl text-slate-400 leadCan you ing-relaxed mb-8">Check out our videos below to learn more.</p>
        </section>
        <livewire:frontend.video-index lazy />
    </div>
</x-layouts.frontend>
