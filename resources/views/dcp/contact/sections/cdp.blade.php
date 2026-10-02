@php
	$id = $parentId ?? "contact-page-tabs_cdp";
@endphp

<x-core::tab id="{{ $id }}-tabs" variant="tab-style-7" class="scaleX p-0 mb-4">
	<x-slot:nav>
		<x-core::tab-nav id="{{ $id }}-tabs_insights" active>CDP Insights</x-core::tab-nav>
		<x-core::tab-nav id="{{ $id }}-tabs_campaign_history">CDP Campaign History</x-core::tab-nav>
		<x-core::tab-nav id="{{ $id }}-tabs_enrichment_history">Enrichment Audit Trail</x-core::tab-nav>
	</x-slot>

	<x-slot:content>
		<x-core::tab-content id="{{ $id }}-tabs_insights" active class="p-0 border-0">
			@include('dcp.contact.sections.cdp-insights', [
				'data' => $data,
				'cdpProfile' => $cdpProfile,
				'campaignHistory' => $campaignHistory,
				'enrichmentHistory' => $enrichmentHistory
			])
		</x-core::tab-content>

		<x-core::tab-content id="{{ $id }}-tabs_campaign_history" class="p-0 border-0">
			@include('dcp.contact.sections.campaign-history', [
				'data' => $data,
				'campaignHistory' => $campaignHistory
			])
		</x-core::tab-content>

		<x-core::tab-content id="{{ $id }}-tabs_enrichment_history" class="p-0 border-0">
			@include('dcp.contact.sections.enrichment-history', [
				'data' => $data,
				'cdpProfile' => $cdpProfile,
				'enrichmentHistory' => $enrichmentHistory
			])
		</x-core::tab-content>
	</x-slot>
</x-core::tab>
