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
        <div>
            <livewire:frontend.video-index lazy />
        </div>
    </div>
</x-layouts.frontend>
