<x-core::page.edit
	:id="$data->id"
	title="Contact"
	:breadcrumbs="$breadcrumbs"
	model="Contact"
	package="crm"
	path="contact/page-index">

	{{-- BASE CRM UPDATE --}}
	<x-slot:header>
		<div class="row mb-3">
			<div class="col">
				<x-core::stage-buttons
					id="contact-page-status_id:status_id"
					:stages="SolarHelper::model('contact_status')::toStage(confirm: true)"
					mode="next-prev"
					final
					:value="$data->status_id" />
			</div>
		</div>
	</x-slot>
	{{-- END BASE CRM UPDATE --}}

	@php
		$tabId = "contact-page-tabs";
	@endphp

	{{-- CRM UPDATE --}}
	<x-core::tab id="{{ $tabId }}" class="p-0 mb-4">
		<x-slot:nav>
			<x-core::tab-nav id="{{ $tabId }}_info" active>Info</x-core::tab-nav>
			<x-core::tab-nav id="{{ $tabId }}_activity">Activity</x-core::tab-nav>

			{{-- SALES UPDATE --}}
			<x-core::tab-nav id="{{ $tabId }}_sales">Sales</x-core::tab-nav>
			{{-- END SALES UPDATE --}}

			{{-- MARKETING UPDATE --}}
			<x-core::tab-nav id="{{ $tabId }}_marketing">Marketing</x-core::tab-nav>
			{{-- END MARKETING UPDATE --}}
			
			{{-- CDP PARENT TAB --}}
			<x-core::tab-nav id="{{ $tabId }}_cdp">
				CDP
			</x-core::tab-nav>

			<x-core::tab-nav id="{{ $tabId }}_notes_files">Notes & Files</x-core::tab-nav>

		</x-slot>

		<x-slot:content>
			@include('sales::pages.contact.sections.info', ['data' => $data, 'active' => true])

			<x-core::tab-content id="{{ $tabId }}_activity" class="p-0 border-0">
				@include('master-data::pages.contact.activity.list', ['id' => $data->id])
			</x-core::tab-content>

			{{-- SALES UPDATE --}}
			@include('sales::pages.contact.sections.sales', ['data' => $data])
			{{-- END SALES UPDATE --}}

			{{-- MARKETING UPDATE --}}
			@include('marketing::pages.contact.sections.marketing', ['data' => $data])
			{{-- END MARKETING UPDATE --}}

			@include('sales::pages.contact.sections.notes-files', ['data' => $data])

			{{-- CDP PARENT TAB CONTENT --}}
			<x-core::tab-content id="{{ $tabId }}_cdp" class="p-0 border-0">
				@include('dcp.contact.sections.cdp', [
					'data' => $data,
					'cdpProfile' => $cdpProfile,
					'campaignHistory' => $campaignHistory,
					'enrichmentHistory' => $enrichmentHistory,
					'parentId' => $tabId . '_cdp'
				])
			</x-core::tab-content>
		</x-slot>
	</x-core::tab>

	{{-- SALES UPDATE --}}
	<x-slot:profile>
		@include('sales::pages.contact.sections.profile-container', ['data' => $data])
	</x-slot>
	{{-- END SALES UPDATE --}}
	{{-- END CRM UPDATE --}}

</x-core::page.edit>
