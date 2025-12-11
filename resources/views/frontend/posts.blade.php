<x-layouts.frontend title="Industry News & Regulatory Updates - Automotive Compliance Standards | ARMP"
    description="Stay informed on the latest regulations and standards affecting the automotive industry. Get updates on FTC Safeguards Rule, OSHA requirements, EPA compliance,
  cyber security threats, and F&I regulations from ARMP's expert team."
    keywords="automotive industry news, dealership regulations, FTC Safeguards updates, OSHA automotive standards, EPA compliance news, automotive cyber security, F&I
  regulations, dealership compliance standards, industry regulatory changes"
    ogTitle="Industry News - Latest Regulations & Standards for Automotive Dealerships"
    ogDescription="Stay informed on the latest regulations and standards affecting the automotive industry. Expert insights on FTC Safeguards, OSHA, EPA, cyber security, and F&I
   compliance from ARMP."
    twitterTitle="ARMP Industry News - Regulatory Updates & Standards"
    twitterDescription="Stay informed on the latest automotive industry regulations and standards. Expert insights on compliance, cyber security, and regulatory changes."
    canonicalUrl="{{ route('news.index') }}">
    <div class="container mx-auto px-6 space-y-24">
        <x-page-title-section title="Industry News"
            subTitle="Stay informed on the latest regulations and standards affecting the automotive industry" />
        <livewire:frontend.post-index lazy />
    </div>
</x-layouts.frontend>
