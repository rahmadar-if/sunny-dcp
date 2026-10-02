<x-core::page.edit
    :id="$data->id"
    title="WhatsApp Blast"
    :breadcrumbs="$breadcrumbs"
    model="WaBlast"
    package="marketing"
    path="wa-blast/page-index"
    profile-position="left">

    @php
        $sendNow_disabled        = false;
        $sendNow_hidden          = false;
        $schedule_disabled       = false;
        $schedule_hidden         = false;
        $scheduleCancel_disabled = false;
        $scheduleCancel_hidden   = false;
        
        $draftStatus     = \Solaris\Marketing\Const\CampaignBlastStatusConst::Draft;
        $scheduledStatus = \Solaris\Marketing\Const\CampaignBlastStatusConst::Scheduled;
        $queueStatus     = \Solaris\Marketing\Const\CampaignBlastStatusConst::Queued;
        $sendingStatus   = \Solaris\Marketing\Const\CampaignBlastStatusConst::Sending;
        $completedStatus = \Solaris\Marketing\Const\CampaignBlastStatusConst::Completed;
        $canceledStatus  = \Solaris\Marketing\Const\CampaignBlastStatusConst::Canceled;
        $failedStatus    = \Solaris\Marketing\Const\CampaignBlastStatusConst::Failed;

        $disabled = !in_array($data->status_id, [$draftStatus, $failedStatus]);

        if(in_array($data->status_id, [$draftStatus, $failedStatus])) {
            $sendNow_disabled        = false;
            $sendNow_hidden          = false;
            $schedule_disabled       = false;
            $schedule_hidden         = false;
            $scheduleCancel_disabled = true;
            $scheduleCancel_hidden   = true;
        } else if(in_array($data->status_id, [$queueStatus, $sendingStatus, $completedStatus, $canceledStatus])) {
            $sendNow_disabled        = true;
            $sendNow_hidden          = true;
            $schedule_disabled       = true;
            $schedule_hidden         = true;
            $scheduleCancel_disabled = true;
            $scheduleCancel_hidden   = true;
        } else if($data->status_id == $scheduledStatus) {
            $sendNow_disabled        = true;
            $sendNow_hidden          = true;
            $schedule_disabled       = true;
            $schedule_hidden         = true;
            $scheduleCancel_disabled = false;
            $scheduleCancel_hidden   = false;
        }
    @endphp

    <x-slot:pre-buttons>
        <x-core::button id="wa-blast-page-send-now" color="success" :disabled="$sendNow_disabled" :hidden="$sendNow_hidden">
            <i class="ti ti-send me-1"></i>Send now
        </x-core::button>
        <x-core::button id="wa-blast-page-schedule" color="info" :disabled="$schedule_disabled" :hidden="$schedule_hidden">
            <i class="ti ti-calendar-time me-1"></i>Schedule
        </x-core::button>
        <x-core::button id="wa-blast-page-schedule-cancel" color="danger" :disabled="$scheduleCancel_disabled" :hidden="$scheduleCancel_hidden">
            <i class="ti ti-calendar-x me-1"></i>Cancel schedule
        </x-core::button>
    </x-slot>

    <x-slot:header>
        <div class="row mb-3">
            <div class="col">
                <x-core::stage-buttons 
                    id="wa-blast-page-status_id:status_id" 
                    :stages="SolarHelper::model('campaign_blast_status')::toStage(disabled: true)" 
                    :value="$data->status_id" />
            </div>
        </div>
    </x-slot>

    <x-slot:profile>
        @include('marketing::pages.wa-blast.sections.profile', ["data" => $data, "disabled" => $disabled])
    </x-slot>

    @php
        $tabId = "wa-blast-page-tabs";
    @endphp

    <x-core::tab id="{{ $tabId }}" class="p-0">
        <x-slot:nav>
            <x-core::tab-nav id="{{ $tabId }}_wa_template" active>WhatsApp Template</x-core::tab-nav>
            {{-- <x-core::tab-nav id="{{ $tabId }}_audience">Audience</x-core::tab-nav> --}}
            {{-- <x-core::tab-nav id="{{ $tabId }}_ida">Indosat IDA</x-core::tab-nav> --}}
            <x-core::tab-nav id="{{ $tabId }}_ida">Data Enrichment</x-core::tab-nav>
            {{-- <x-core::tab-nav id="{{ $tabId }}_campaign_status">Campaign Status</x-core::tab-nav>
            <x-core::tab-nav id="{{ $tabId }}_history">History</x-core::tab-nav> --}}
            <x-core::tab-nav id="{{ $tabId }}_attachment">Attachment</x-core::tab-nav>
            <x-core::tab-nav id="{{ $tabId }}_notes">Notes</x-core::tab-nav>
        </x-slot>

        <x-slot:content>
            <x-core::tab-content id="{{ $tabId }}_wa_template" active class="mt-4 p-0 border-0">
                @include("marketing::pages.wa-blast.sections.wa-template", ["data" => $data, "disabled" => $disabled])
            </x-core::tab-content>

            <x-core::tab-content id="{{ $tabId }}_audience" class="p-0 border-0 mt-4 ">
                @include("marketing::pages.wa-blast.audience.list", ["id" => $data->id, "disabled" => $disabled])
            </x-core::tab-content>

            <x-core::tab-content id="{{ $tabId }}_ida" class="p-0 border-0 mt-4 ">
                @include("dcp.campaign.ida-tab", ["data" => $data, "disabled" => $disabled])
            </x-core::tab-content>

            <x-core::tab-content id="{{ $tabId }}_history" class="p-0 border-0 mt-4 ">
                @include("marketing::pages.wa-blast.sections.history", ["id" => $data->id, "tabId" => $tabId])
            </x-core::tab-content>

            <x-core::tab-content id="{{ $tabId }}_attachment" class="p-0 border-0 mt-4 ">
                <x-core::attachment id="wa-blast-page-attachment" relation="wa_blasts:{{ $data->id }}"/>
            </x-core::tab-content>

            <x-core::tab-content id="{{ $tabId }}_notes" class="p-0 border-0 mt-4">
                <x-core::notes 
                    id="wa-blast-page-notes:notes"
                    model="WaBlast"
                    column="notes"
                    :record_id="$data->id">{!! $data->notes !!}</x-core::notes>
            </x-core::tab-content>
        </x-slot>
    </x-core::tab>

    <x-slot:footer>
        <x-core::tab-content id="{{ $tabId }}_campaign_status" class="p-0 border-0">
            @include("marketing::pages.wa-blast.sections.campaign-status", ["data" => $data])
        </x-core::tab-content>
    </x-slot>

    @push('modal-content')
        @include("marketing::pages.wa-blast.schedule-modal")

        @include("marketing::pages.wa-blast.test-wa-modal")

        @include("dcp.campaign.ida-modal")
    @endpush

</x-core::page.edit>
