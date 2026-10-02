<x-core::page.list
    id="contact"
    title="Contact"
    class="table-hover"
    :breadcrumbs="$breadcrumbs"
    model="Contact"
    package="master-data"
    path="contact/list-index"
    new="@contact-modal"
    length="25"
    :order_by="['name:asc']"
    import export folder lazy delete_all
    extend_columns="job_title,primary_mobile_phone,email,profile_picture_id">

    <x-slot:buttons>
        <button type="button" class="btn btn-primary btn-wave waves-effect waves-light d-flex align-items-center gap-1" id="btnOpenContactEnrichmentFilter">
            <i class="ri-radar-line"></i>
            <span>Request Enrichment</span>
        </button>
        <!-- Button Cleansing Data khusus Manual CRM -->
        <button type="button" class="btn btn-warning btn-wave waves-effect waves-light d-none align-items-center gap-1 text-white shadow-sm" id="btnOpenCleansingDataModal">
            <i class="ri-magic-line"></i>
            <span>Cleansing Data</span>
            <span class="badge bg-white text-dark rounded-pill ms-1" id="badgeSelectedCleansingCount">0</span>
        </button>
    </x-slot>

    <x-slot:tableLeftAction>
        <!-- CONTACT DATA SOURCE RADIO FILTER (Directly beside Folders button) -->
        <div class="btn-group btn-group-sm ms-2" role="group" aria-label="Contact Data Source Filter" id="contactSourceRadioGroup">
            <input type="radio" class="btn-check" name="cdp_source_filter" id="srcRadioAll" value="all" autocomplete="off" checked>
            <label class="btn btn-outline-light text-dark fw-medium d-flex align-items-center gap-1 px-3 py-1" for="srcRadioAll">
                <span>All Contacts</span>
                <span class="badge bg-light text-dark rounded-pill ms-1 border" id="badgeCountAll">{{ $stats['total'] ?? 19 }}</span>
            </label>

            <input type="radio" class="btn-check" name="cdp_source_filter" id="srcRadioEnriched" value="enriched" autocomplete="off">
            <label class="btn btn-outline-light text-primary fw-medium d-flex align-items-center gap-1 px-3 py-1" for="srcRadioEnriched">
                <i class="ri-radar-line text-primary"></i>
                <span>CDP Enriched</span>
                <span class="badge bg-primary text-white rounded-pill ms-1" id="badgeCountEnriched">{{ $stats['enriched'] ?? 18 }}</span>
            </label>

            <input type="radio" class="btn-check" name="cdp_source_filter" id="srcRadioManual" value="manual" autocomplete="off">
            <label class="btn btn-outline-light text-secondary fw-medium d-flex align-items-center gap-1 px-3 py-1" for="srcRadioManual">
                <i class="ri-user-line text-secondary"></i>
                <span>Manual CRM</span>
                <span class="badge bg-secondary text-white rounded-pill ms-1" id="badgeCountManual">{{ $stats['manual'] ?? 1 }}</span>
            </label>
        </div>
    </x-slot>

    <x-slot:header>
        <!-- APPLIED ENRICHMENT SYNC CRITERIA BAR -->
        <div class="card custom-card shadow-sm mb-3 border-0 bg-light-transparent" id="contactFilterBar" style="display: none;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center flex-wrap gap-2" id="contactFilterBadgesContainer">
                        <span class="fs-12 fw-bold text-muted text-uppercase">Telco Enrichment Query:</span>
                        <div id="contactFilterBadgesList" class="d-flex flex-wrap gap-1"></div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-transparent text-primary border border-primary border-opacity-25 fs-12 px-2 py-1" id="filteredContactCountBadge">
                            Showing All Contacts
                        </span>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="btnClearContactFilters">
                            <i class="ri-close-line me-1"></i>Reset Query
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    
    <x-slot:table-column>
        <x-core::table-action-column :view="false" width="50px" label="#" />
            
        <x-core::table-column 
            class="text-start"
            cell_class="text-nowrap text-start" 
            data="name" 
            searchable 
            orderable
            width="260px">
            Name
        </x-core::table-column>
        
        <x-core::table-column 
            class="text-start"
            cell_class="text-nowrap text-start" 
            data="account.name" 
            lookup="primary_phone,email,profile_picture_id" 
            searchable 
            orderable
            width="170px">
            Account
        </x-core::table-column>
        
        <x-core::table-column 
            class="text-start"
            cell_class="text-nowrap text-start" 
            data="job_title" 
            searchable 
            orderable
            width="160px">
            Job Title
        </x-core::table-column>

        <x-core::table-column 
            class="text-start"
            cell_class="text-nowrap text-start" 
            data="id"
            name="demographics"
            :searchable="false" 
            :orderable="false"
            width="320px">
            CDP Demographics & Intelligence
        </x-core::table-column>

        <x-core::table-column 
            class="text-start"
            cell_class="text-nowrap text-start" 
            data="id"
            name="cdp_action"
            :searchable="false" 
            :orderable="false"
            width="140px">
            Action
        </x-core::table-column>
    </x-slot>

    @push('modal-content')
        @include("master-data::pages.contact.modal")
        @include("dcp.contact.partials.enrichment-filter-modal")
        @include("dcp.contact.partials.detail-drawer")
        @include("dcp.contact.partials.cleansing-modal")
    @endpush

    @push('styles')
    <style>
        #contact_list_solar_wrapper th,
        #contact_list_solar_wrapper td {
            vertical-align: middle !important;
        }
        #contact_list_solar_wrapper th[field-name="job_title"],
        #contact_list_solar_wrapper td:nth-child(4),
        #contact_list_solar_wrapper th[field-name="demographics"],
        #contact_list_solar_wrapper td:nth-child(5),
        #contact_list_solar_wrapper th[field-name="cdp_action"],
        #contact_list_solar_wrapper td:nth-child(6) {
            text-align: left !important;
        }

        .cleansing-check-card {
            transition: all 0.2s ease-in-out;
            border: 1.5px solid #e9edf4 !important;
            background-color: #ffffff;
        }
        .cleansing-check-card:hover {
            border-color: #f5b849 !important;
            background-color: rgba(245, 184, 73, 0.04);
            transform: translateY(-2px);
        }
        .cleansing-check-card.is-selected {
            border-color: #f5b849 !important;
            background-color: rgba(245, 184, 73, 0.06);
            box-shadow: 0 2px 6px rgba(245, 184, 73, 0.15);
        }
        .cleansing-check-card .form-check-input:checked {
            background-color: #f5b849;
            border-color: #f5b849;
        }
    </style>
    @endpush

    @push('scripts')
    <script id="dcpEnrichedProfilesMap" type="application/json">
        {!! json_encode($enrichedMap ?? []) !!}
    </script>
    <script id="dcpInitialStats" type="application/json">
        {!! json_encode($stats ?? ['total' => 19, 'enriched' => 18, 'manual' => 1]) !!}
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const targetBase = '{{ url("/dcp/contact/edit") }}';
            const filterUrl = '{{ route("dcp.contact.filter") }}';
            const profileUrl = '{{ url("/dcp/contact/profile") }}';
            const enrichUrl = '{{ url("/dcp/contact") }}';

            let rawEnrichedMap = {};
            try {
                const jsonEl = document.getElementById('dcpEnrichedProfilesMap');
                if (jsonEl && jsonEl.textContent) {
                    rawEnrichedMap = JSON.parse(jsonEl.textContent);
                }
            } catch (e) {
                console.warn('Failed parsing enriched profiles map:', e);
            }

            let currentStats = { total: 19, enriched: 18, manual: 1 };
            try {
                const statsEl = document.getElementById('dcpInitialStats');
                if (statsEl && statsEl.textContent) {
                    currentStats = JSON.parse(statsEl.textContent);
                }
            } catch (e) {}

            let activeMatchingIds = null;
            let currentSourceFilter = 'all'; // 'all', 'enriched', 'manual'

            // Track selected manual contacts for Cleansing Data
            const selectedCleansingIds = new Set();
            const cleansingContactNames = {};

            const filterModalEl = document.getElementById('contactEnrichmentFilterModal');
            let filterModal = null;
            if (filterModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                filterModal = new bootstrap.Modal(filterModalEl);
            }

            const offcanvasEl = document.getElementById('contactDetailOffcanvas');
            let detailOffcanvas = null;
            if (offcanvasEl && typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
                detailOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
            }

            // Open Request Telco Enrichment Modal
            const btnOpenFilter = document.getElementById('btnOpenContactEnrichmentFilter');
            if (btnOpenFilter) {
                btnOpenFilter.addEventListener('click', function (e) {
                    e.preventDefault();
                    resetSyncBox();
                    if (filterModal) filterModal.show();
                    else if (typeof bootstrap !== 'undefined') new bootstrap.Modal(filterModalEl).show();
                });
            }

            // Reset form inside modal
            const btnResetForm = document.getElementById('btnResetContactFilterForm');
            if (btnResetForm) {
                btnResetForm.addEventListener('click', function () {
                    const form = document.getElementById('contactEnrichmentFilterForm');
                    if (form) {
                        form.reset();
                        document.getElementById('cGenderAll').checked = true;
                    }
                    resetSyncBox();
                });
            }

            // Reset Filter Criteria Bar in header
            const btnClearFilters = document.getElementById('btnClearContactFilters');
            if (btnClearFilters) {
                btnClearFilters.addEventListener('click', function () {
                    clearAllFilters();
                });
            }

            // Cleansing Data Button & Radio Filter logic
            const btnCleansingData = document.getElementById('btnOpenCleansingDataModal');
            function updateCleansingButtonVisibility() {
                if (btnCleansingData) {
                    if (currentSourceFilter === 'manual') {
                        btnCleansingData.classList.remove('d-none');
                        btnCleansingData.classList.add('d-flex');
                    } else {
                        btnCleansingData.classList.add('d-none');
                        btnCleansingData.classList.remove('d-flex');
                    }
                }
            }

            function updateCleansingBadge() {
                const countBadge = document.getElementById('badgeSelectedCleansingCount');
                if (countBadge) {
                    countBadge.innerText = selectedCleansingIds.size;
                }
            }

            // Radio Button Group next to Folders
            const sourceRadios = document.querySelectorAll('input[name="cdp_source_filter"]');
            sourceRadios.forEach(function (radio) {
                radio.addEventListener('change', function () {
                    currentSourceFilter = this.value;
                    updateCleansingButtonVisibility();
                    filterTableRows();
                });
            });

            function updateBadgeCounts() {
                const bAll = document.getElementById('badgeCountAll');
                const bEnriched = document.getElementById('badgeCountEnriched');
                const bManual = document.getElementById('badgeCountManual');
                if (bAll) bAll.innerText = currentStats.total;
                if (bEnriched) bEnriched.innerText = currentStats.enriched;
                if (bManual) bManual.innerText = currentStats.manual;
            }

            function clearAllFilters() {
                activeMatchingIds = null;
                const filterBar = document.getElementById('contactFilterBar');
                if (filterBar) filterBar.style.display = 'none';

                const badgesList = document.getElementById('contactFilterBadgesList');
                if (badgesList) badgesList.innerHTML = '';

                const form = document.getElementById('contactEnrichmentFilterForm');
                if (form) {
                    form.reset();
                    document.getElementById('cGenderAll').checked = true;
                }

                filterTableRows();
                document.getElementById('filteredContactCountBadge').innerText = 'Showing All Contacts';
            }

            function resetSyncBox() {
                const box = document.getElementById('enrichmentSyncProgressBox');
                if (box) box.classList.add('d-none');
                const bar = document.getElementById('syncProgressBar');
                if (bar) bar.style.width = '0%';
                const text = document.getElementById('syncProgressText');
                if (text) text.innerHTML = '<span class="spinner-border spinner-border-sm text-primary"></span><span>Connecting to Telco Provider Gateway...</span>';
                const pct = document.getElementById('syncProgressPct');
                if (pct) pct.innerText = '0%';
            }

            // Handle "Request Telco Enrichment" form submission with animated carrier sync
            const filterForm = document.getElementById('contactEnrichmentFilterForm');
            if (filterForm) {
                filterForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('btnApplyContactFilterSubmit');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Syncing Gateway...';
                    }

                    const progressBox = document.getElementById('enrichmentSyncProgressBox');
                    const progressBar = document.getElementById('syncProgressBar');
                    const progressText = document.getElementById('syncProgressText');
                    const progressPct = document.getElementById('syncProgressPct');

                    if (progressBox) progressBox.classList.remove('d-none');
                    if (progressBar) progressBar.style.width = '35%';
                    if (progressPct) progressPct.innerText = '35%';

                    setTimeout(() => {
                        if (progressBar) progressBar.style.width = '75%';
                        if (progressPct) progressPct.innerText = '75%';
                        if (progressText) progressText.innerHTML = '<span class="spinner-border spinner-border-sm text-primary"></span><span>Querying 18 consented subscriber profiles...</span>';
                    }, 400);

                    const formData = new FormData(filterForm);

                    setTimeout(() => {
                        fetch(filterUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (progressBar) progressBar.style.width = '100%';
                            if (progressPct) progressPct.innerText = '100%';
                            if (progressText) progressText.innerHTML = '<i class="ri-check-line text-success fs-16 me-1"></i><span class="text-success fw-bold">Telco Intelligence Synchronized!</span>';

                            setTimeout(() => {
                                if (submitBtn) {
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = '<i class="ri-radar-line me-1"></i><span>Request & Sync Enrichment</span>';
                                }
                                if (res.status === 'success') {
                                    applyFilterResults(res.data);
                                    if (filterModal) filterModal.hide();
                                }
                            }, 500);
                        })
                        .catch(err => {
                            console.error('Filter submission error:', err);
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = '<i class="ri-radar-line me-1"></i><span>Request & Sync Enrichment</span>';
                            }
                            resetSyncBox();
                        });
                    }, 800);
                });
            }

            function applyFilterResults(data) {
                activeMatchingIds = data.matching_contact_ids || [];
                const badges = data.active_filter_badges || [];
                const counts = data.counts || { total: 0, enriched: 0, manual: 0 };

                const filterBar = document.getElementById('contactFilterBar');
                const badgesList = document.getElementById('contactFilterBadgesList');
                const countBadge = document.getElementById('filteredContactCountBadge');

                if (badges.length > 0) {
                    filterBar.style.display = '';
                    badgesList.innerHTML = '';
                    badges.forEach(function (b) {
                        const span = document.createElement('span');
                        span.className = 'badge bg-white text-dark border py-1 px-2 fs-11';
                        span.innerText = b;
                        badgesList.appendChild(span);
                    });

                    countBadge.innerHTML = `Matched <strong>${counts.total}</strong> Contacts (${counts.enriched} Enriched, ${counts.manual} Manual)`;
                } else {
                    filterBar.style.display = 'none';
                    countBadge.innerText = 'Showing All Contacts';
                }

                filterTableRows();
            }

            function filterTableRows() {
                const rows = document.querySelectorAll('#contact_list tbody tr');
                if (!rows.length) return;

                rows.forEach(function (row) {
                    const editLink = row.querySelector('a[href*="/edit/"]');
                    if (!editLink) return;

                    const href = editLink.getAttribute('href');
                    const parts = href.split(/\/edit\//);
                    const contactId = parts[1] ? parts[1].split(/[?#]/)[0] : null;

                    const isEnriched = row.dataset.isEnriched === 'true';
                    const isFailed = row.dataset.isFailed === 'true';

                    // 1. Check Source Radio (All, Enriched, Manual)
                    let passSource = true;
                    if (currentSourceFilter === 'enriched') {
                        passSource = isEnriched && !isFailed;
                    } else if (currentSourceFilter === 'manual') {
                        passSource = !isEnriched || isFailed;
                    }

                    // 2. Check Criteria filter (if active)
                    let passCriteria = true;
                    if (activeMatchingIds !== null) {
                        passCriteria = contactId && activeMatchingIds.includes(contactId);
                    }

                    if (passSource && passCriteria) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Reset horizontal scroll to beginning when changing tabs to prevent desync
                const scrollBody = document.querySelector('#contact_list_solar_wrapper .dataTables_scrollBody');
                if (scrollBody) {
                    scrollBody.scrollLeft = 0;
                }
            }

            // Function to enhance table rows with separate Demographics column and Action column
            function enrichTableRows(forceReRender = false) {
                const rows = document.querySelectorAll('#contact_list tbody tr');
                rows.forEach(function (row) {
                    if (row.classList.contains('cdp-enhanced') && !forceReRender) return;

                    const editLink = row.querySelector('a[href*="/edit/"]');
                    if (!editLink) return;

                    const href = editLink.getAttribute('href');
                    const parts = href.split(/\/edit\//);
                    const contactId = parts[1] ? parts[1].split(/[?#]/)[0] : null;

                    // Ensure href points to DCP contact route
                    if (contactId) {
                        editLink.setAttribute('href', targetBase + '/' + contactId);
                    }

                    // Extract contact phone & name
                    const phoneEl = row.querySelector('.ri-phone-line, .ri-smartphone-line');
                    const phoneText = phoneEl ? phoneEl.parentElement.textContent.replace(/[^0-9]/g, '') : '';
                    const contactName = editLink.textContent.trim();
                    const contactNameLower = contactName.toLowerCase();

                    // Check if contact has CDP enriched profile
                    let profile = null;
                    if (contactId && rawEnrichedMap[contactId]) {
                        profile = rawEnrichedMap[contactId];
                    } else if (phoneText && rawEnrichedMap['phone_' + phoneText]) {
                        profile = rawEnrichedMap['phone_' + phoneText];
                    } else if (contactNameLower && rawEnrichedMap['name_' + contactNameLower]) {
                        profile = rawEnrichedMap['name_' + contactNameLower];
                    }

                    const isFailed = profile && (profile.enrichment_status === 'Failed' || profile.phone_status === 'Inactive' || (phoneText && phoneText.length < 10));
                    const isEnriched = profile && !isFailed && profile.enrichment_status === 'Enriched';

                    row.dataset.isEnriched = isEnriched ? 'true' : 'false';
                    row.dataset.isFailed = isFailed ? 'true' : 'false';

                    // KEEP NAME COLUMN (td:nth-child(2)) CLEAN!
                    // Remove any old appended badges inside name column if present
                    const oldBadges = row.querySelectorAll('.cdp-badge-tag');
                    oldBadges.forEach(b => b.remove());

                    // REMOVE old eye button inside first action column (td:first-child)
                    const oldEyeBtn = row.querySelector('td:first-child .view-cdp-eye-btn');
                    if (oldEyeBtn) oldEyeBtn.remove();

                    // Map all columns cleanly
                    const cells = row.querySelectorAll('td');
                    if (cells.length >= 6) {
                        const accountCell = cells[2]; // 3rd column: Account
                        const jobCell = cells[3];     // 4th column: Job Title
                        const demoCell = cells[4];    // 5th column: Demographics
                        const actionCell = cells[5];  // 6th column: Action

                        // Format Account Column
                        if (accountCell) {
                            accountCell.className = 'text-nowrap text-start align-middle';
                            if (profile && profile.company) {
                                accountCell.innerHTML = `
                                    <div class="d-flex align-items-center gap-1 text-dark fs-12">
                                        <i class="ri-building-line text-muted"></i>
                                        <span class="text-truncate" title="${profile.company}">${profile.company}</span>
                                    </div>
                                `;
                            } else {
                                const currentAcc = accountCell.textContent.trim();
                                if (currentAcc && currentAcc !== '-') {
                                    accountCell.innerHTML = `
                                        <div class="d-flex align-items-center gap-1 text-dark fs-12">
                                            <i class="ri-building-line text-muted"></i>
                                            <span class="text-truncate" title="${currentAcc}">${currentAcc}</span>
                                        </div>
                                    `;
                                } else {
                                    accountCell.innerHTML = `<span class="text-muted fs-12">-</span>`;
                                }
                            }
                        }

                        // Format Job Title Column
                        if (jobCell) {
                            jobCell.className = 'text-nowrap text-start align-middle';
                            const currentJob = jobCell.textContent.trim();
                            if (profile && profile.job_title) {
                                jobCell.innerHTML = `<span class="fw-medium text-dark fs-12">${profile.job_title}</span>`;
                            } else if (currentJob && currentJob !== '-') {
                                jobCell.innerHTML = `<span class="fw-medium text-dark fs-12">${currentJob}</span>`;
                            } else {
                                jobCell.innerHTML = `<span class="text-muted fs-12">-</span>`;
                            }
                        }

                        // Render Demographics Cell
                        if (demoCell) {
                            demoCell.className = 'text-nowrap text-start align-middle';
                            if (isFailed) {
                                demoCell.innerHTML = `
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex align-items-center gap-1 flex-wrap">
                                            <span class="badge bg-danger-transparent text-danger border border-danger border-opacity-25 fs-11 py-1 px-2">
                                                <i class="ri-close-circle-line me-1"></i>Gagal Enrich
                                            </span>
                                            <span class="badge bg-danger text-white fs-11 py-1 px-2">
                                                Nomor Tidak Aktif
                                            </span>
                                        </div>
                                        <div class="fs-11 text-danger d-flex align-items-center gap-1 mt-1">
                                            <i class="ri-error-warning-line"></i>
                                            <span>MSISDN tidak terdaftar di HLR Gateway (< 10 Digit)</span>
                                        </div>
                                    </div>
                                `;
                            } else if (isEnriched) {
                                demoCell.innerHTML = `
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex align-items-center gap-1 flex-wrap">
                                            <span class="badge bg-primary-transparent text-primary border border-primary border-opacity-25 fs-11 py-1 px-2">
                                                <i class="ri-radar-line me-1"></i>CDP Enriched
                                            </span>
                                            <span class="badge bg-light text-dark border fs-11 py-1 px-2">
                                                BP: ${profile.buying_power || 'Standard'}
                                            </span>
                                            <span class="badge bg-success-transparent text-success border border-success border-opacity-25 fs-11 py-1 px-2">
                                                Score: ${profile.credit_score || '750'}
                                            </span>
                                        </div>
                                        <div class="fs-11 text-muted d-flex align-items-center gap-1 mt-1">
                                            <i class="ri-map-pin-line text-primary"></i>
                                            <span>${profile.city || 'Jakarta'}, ${profile.residential_area || 'High Class'}</span>
                                            <span class="text-muted">&bull;</span>
                                            <span>${profile.phone_device_type || 'iPhone'}</span>
                                        </div>
                                    </div>
                                `;
                            } else {
                                demoCell.innerHTML = `
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-secondary-transparent text-secondary border border-secondary border-opacity-25 fs-11 py-1 px-2">
                                            <i class="ri-user-line me-1"></i>Manual CRM
                                        </span>
                                        <span class="badge bg-light text-muted border fs-11 py-1 px-2">
                                            Unverified Profile
                                        </span>
                                    </div>
                                `;
                            }
                        }

                        // Render Action Cell on Right Side
                        if (actionCell) {
                            actionCell.className = 'text-nowrap text-start align-middle';
                            if (isFailed) {
                                const isChecked = selectedCleansingIds.has(contactId);
                                actionCell.innerHTML = `
                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                        <input type="checkbox" class="form-check-input manual-cleansing-checkbox m-0" 
                                            style="width: 16px; height: 16px; cursor: pointer;" 
                                            title="Pilih untuk Cleansing Ulang" 
                                            data-contact-id="${contactId}" 
                                            data-contact-name="${contactName}"
                                            ${isChecked ? 'checked' : ''}>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-enrich-single-contact d-flex align-items-center gap-1 px-2 py-1" title="Nomor Tidak Aktif. Klik untuk validasi ulang" data-contact-id="${contactId}" data-contact-name="${contactName}">
                                            <i class="ri-error-warning-line"></i>
                                            <span>Re-check</span>
                                        </button>
                                    </div>
                                `;
                                const enrichBtn = actionCell.querySelector('.btn-enrich-single-contact');
                                if (enrichBtn) {
                                    enrichBtn.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        triggerSingleContactEnrich(contactId, contactName, row);
                                    });
                                }
                                const chkBox = actionCell.querySelector('.manual-cleansing-checkbox');
                                if (chkBox) {
                                    chkBox.addEventListener('change', function (e) {
                                        e.stopPropagation();
                                        if (this.checked) {
                                            selectedCleansingIds.add(contactId);
                                            cleansingContactNames[contactId] = contactName;
                                        } else {
                                            selectedCleansingIds.delete(contactId);
                                        }
                                        updateCleansingBadge();
                                    });
                                }
                            } else if (isEnriched) {
                                actionCell.innerHTML = `
                                    <div class="d-flex align-items-center justify-content-start">
                                        <button type="button" class="btn btn-icon btn-sm btn-outline-primary view-cdp-eye-btn" title="View CDP Enriched Insights" data-contact-id="${contactId}">
                                            <i class="ri-eye-line fs-14"></i>
                                        </button>
                                    </div>
                                `;
                                const eyeBtn = actionCell.querySelector('.view-cdp-eye-btn');
                                if (eyeBtn) {
                                    eyeBtn.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        openDetailDrawer(contactId, profile);
                                    });
                                }
                            } else {
                                // Dedicated "Enrich" Button & Cleansing Checkbox for manual contacts
                                const isChecked = selectedCleansingIds.has(contactId);
                                actionCell.innerHTML = `
                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                        <input type="checkbox" class="form-check-input manual-cleansing-checkbox m-0" 
                                            style="width: 16px; height: 16px; cursor: pointer;" 
                                            title="Pilih untuk Cleansing Data" 
                                            data-contact-id="${contactId}" 
                                            data-contact-name="${contactName}"
                                            ${isChecked ? 'checked' : ''}>
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-enrich-single-contact d-flex align-items-center gap-1 px-2 py-1" title="Enrich this contact via Telco Gateway" data-contact-id="${contactId}" data-contact-name="${contactName}">
                                            <i class="ri-radar-line"></i>
                                            <span>Enrich</span>
                                        </button>
                                    </div>
                                `;
                                const enrichBtn = actionCell.querySelector('.btn-enrich-single-contact');
                                if (enrichBtn) {
                                    enrichBtn.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        triggerSingleContactEnrich(contactId, contactName, row);
                                    });
                                }
                                const chkBox = actionCell.querySelector('.manual-cleansing-checkbox');
                                if (chkBox) {
                                    chkBox.addEventListener('change', function (e) {
                                        e.stopPropagation();
                                        if (this.checked) {
                                            selectedCleansingIds.add(contactId);
                                            cleansingContactNames[contactId] = contactName;
                                        } else {
                                            selectedCleansingIds.delete(contactId);
                                        }
                                        updateCleansingBadge();
                                    });
                                }
                            }
                        }
                    }

                    row.classList.add('cdp-enhanced');
                });

                filterTableRows();

                // Recalculate and snap column widths to prevent scroll/misalignment
                setTimeout(() => {
                    try {
                        if (typeof $ !== 'undefined' && $.fn.DataTable && $.fn.DataTable.isDataTable('#contact_list')) {
                            $('#contact_list').DataTable().columns.adjust();
                        }
                    } catch (e) {}
                }, 50);
            }

            // Function to trigger on-the-fly single contact enrichment
            function triggerSingleContactEnrich(contactId, contactName, row) {
                const btn = row.querySelector('.btn-enrich-single-contact');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Enriching...';
                }

                fetch(`${enrichUrl}/${contactId}/enrich`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'failed_enrichment' || (res.data && res.data.enrichment_status === 'Failed')) {
                        rawEnrichedMap[contactId] = res.data;
                        row.dataset.isEnriched = 'false';
                        row.dataset.isFailed = 'true';
                        selectedCleansingIds.delete(contactId);
                        updateCleansingBadge();

                        // Re-render row cells immediately
                        enrichTableRows(true);

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Enrichment Gagal: Nomor Tidak Aktif',
                                html: `Nomor telepon kontak <strong>${contactName}</strong> tidak valid / kurang dari 10 digit.<br><span class="badge bg-danger text-white mt-2 px-3 py-1 fs-12">HLR Status: Inactive Subscriber</span><br><small class="text-muted mt-2 d-block">Data ditandai sebagai "Gagal Enrich" agar dapat dibandingkan dengan kontak valid.</small>`,
                                confirmButtonColor: '#fe7d00',
                                confirmButtonText: 'Tutup'
                            });
                        }
                    } else if (res.status === 'success' && res.data) {
                        // Store newly enriched profile in map
                        rawEnrichedMap[contactId] = res.data;
                        row.dataset.isEnriched = 'true';
                        row.dataset.isFailed = 'false';
                        selectedCleansingIds.delete(contactId);
                        updateCleansingBadge();

                        // Update counters
                        currentStats.enriched = (currentStats.enriched || 18) + 1;
                        currentStats.manual = Math.max(0, (currentStats.manual || 1) - 1);
                        updateBadgeCounts();

                        // Re-render row cells immediately
                        enrichTableRows(true);

                        // Show standard modal success feedback
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Enrichment Successful!',
                                html: `<p class="text-muted fs-13 mb-0">Kontak <strong>${contactName}</strong> berhasil diverifikasi dan diperkaya dengan Telco Gateway intelligence.</p>`,
                                confirmButtonColor: '#fe7d00',
                                confirmButtonText: 'Tutup'
                            });
                        }
                    }
                })
                .catch(err => {
                    console.error('Enrichment error:', err);
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="ri-radar-line me-1"></i>Enrich';
                    }
                });
            }

            // Function to open and populate Customer Detail Drawer
            function openDetailDrawer(contactId, cachedProfile) {
                if (cachedProfile) {
                    renderDrawerData(cachedProfile);
                    if (detailOffcanvas) detailOffcanvas.show();
                    return;
                }

                fetch(`${profileUrl}/${contactId}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success' && res.data) {
                        renderDrawerData(res.data);
                    } else if (res.status === 'manual') {
                        renderManualDrawer(res.data);
                    }
                    if (detailOffcanvas) detailOffcanvas.show();
                })
                .catch(err => {
                    console.error('Failed to load profile:', err);
                });
            }

            function renderDrawerData(p) {
                document.getElementById('drawerManualAlert').classList.add('d-none');
                document.getElementById('drawerEnrichedContent').classList.remove('d-none');
                
                document.getElementById('drawerContactName').innerText = p.name || 'Unknown';
                document.getElementById('drawerContactPhone').innerText = p.phone_number || '-';
                document.getElementById('drawerEnrichmentStatusBadge').className = 'badge bg-primary-transparent text-primary ms-2 fs-10';
                document.getElementById('drawerEnrichmentStatusBadge').innerText = 'CDP Enriched';

                document.getElementById('drawerContactCompany').innerText = p.company || '-';
                document.getElementById('drawerContactJobTitle').innerText = p.job_title || '-';
                document.getElementById('drawerContactEmail').innerText = p.email || '-';
                document.getElementById('drawerContactResidentialArea').innerText = `${p.city || ''}, ${p.residential_area || '-'}`;

                let social = '-';
                if (p.social_media) {
                    if (typeof p.social_media === 'object') {
                        social = Object.values(p.social_media).filter(Boolean).join(', ');
                    } else {
                        social = p.social_media;
                    }
                }
                document.getElementById('drawerContactSocialMedia').innerText = social || '-';

                // Top Apps & Places
                renderPills('drawerContactTopApps', p.top_applications, 'bg-light text-dark border');
                renderPills('drawerContactVisitedPlaces', p.frequently_visited_places, 'bg-light text-dark border');
                renderPills('drawerContactProducts', p.most_purchased_products, 'bg-light text-dark border');

                document.getElementById('drawerContactDevice').innerText = p.phone_device_type || '-';
                document.getElementById('drawerContactBuyingPower').innerText = p.buying_power || 'Standard';
                document.getElementById('drawerContactCarrier').innerText = p.competitor_product_usage || '-';

                // Credit & Risk
                const score = p.credit_score || 750;
                document.getElementById('drawerContactCreditScore').innerText = score;
                const pct = Math.min(100, Math.max(10, ((score - 300) / 550) * 100));
                const bar = document.getElementById('drawerContactCreditBar');
                bar.style.width = pct + '%';
                bar.className = 'progress-bar ' + (score >= 750 ? 'bg-success' : (score >= 600 ? 'bg-primary' : 'bg-warning'));

                document.getElementById('drawerContactPaymentHistory').innerText = p.payment_history || 'Smooth';
                document.getElementById('drawerContactFraudRisk').innerText = p.fraud_risk || 'Low';
                document.getElementById('drawerContactGambling').innerText = p.gambling_indicator ? 'Detected' : 'Clean';
                document.getElementById('drawerContactGambling').className = 'col-6 fw-semibold ' + (p.gambling_indicator ? 'text-danger' : 'text-success');
                document.getElementById('drawerContactBlacklist').innerText = p.blacklist_status ? 'Blacklisted' : 'Clean';
                document.getElementById('drawerContactBlacklist').className = 'col-6 fw-semibold ' + (p.blacklist_status ? 'text-danger' : 'text-success');
            }

            function renderManualDrawer(m) {
                document.getElementById('drawerManualAlert').classList.remove('d-none');
                document.getElementById('drawerContactName').innerText = m.name || 'Unknown';
                document.getElementById('drawerContactPhone').innerText = m.phone_number || '-';
                document.getElementById('drawerEnrichmentStatusBadge').className = 'badge bg-secondary-transparent text-secondary ms-2 fs-10';
                document.getElementById('drawerEnrichmentStatusBadge').innerText = 'Manual CRM';

                document.getElementById('drawerContactCompany').innerText = m.company || '-';
                document.getElementById('drawerContactJobTitle').innerText = m.job_title || '-';
                document.getElementById('drawerContactEmail').innerText = m.email || '-';
                document.getElementById('drawerContactResidentialArea').innerText = 'Unverified (Manual Entry)';
                document.getElementById('drawerContactSocialMedia').innerText = '-';

                renderPills('drawerContactTopApps', ['No Telco Data'], 'bg-light text-muted border');
                renderPills('drawerContactVisitedPlaces', ['No Geolocation Data'], 'bg-light text-muted border');
                renderPills('drawerContactProducts', ['No Purchase Intelligence'], 'bg-light text-muted border');

                document.getElementById('drawerContactDevice').innerText = 'Unknown Device';
                document.getElementById('drawerContactBuyingPower').innerText = 'Unrated';
                document.getElementById('drawerContactCarrier').innerText = 'Standard Network';

                document.getElementById('drawerContactCreditScore').innerText = 'Unrated';
                document.getElementById('drawerContactCreditBar').style.width = '0%';
                document.getElementById('drawerContactPaymentHistory').innerText = 'Not Scored';
                document.getElementById('drawerContactFraudRisk').innerText = 'Unverified';
                document.getElementById('drawerContactGambling').innerText = 'Unverified';
                document.getElementById('drawerContactBlacklist').innerText = 'Unverified';
            }

            function renderPills(containerId, items, badgeClass) {
                const el = document.getElementById(containerId);
                if (!el) return;
                el.innerHTML = '';
                if (!items || !items.length) {
                    el.innerHTML = '<span class="text-muted fs-11">-</span>';
                    return;
                }
                const arr = Array.isArray(items) ? items : [items];
                arr.forEach(function (item) {
                    const span = document.createElement('span');
                    span.className = 'badge fs-11 py-1 px-2 ' + badgeClass;
                    span.innerText = item;
                    el.appendChild(span);
                });
            }

            // Capture clicks on contact links to keep route under DCP
            document.addEventListener('click', function (e) {
                const a = e.target.closest('a');
                if (a && a.href && a.href.includes('/master-data/contact/edit/')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const parts = a.href.split(/\/edit\//);
                    if (parts[1]) {
                        window.location.href = targetBase + '/' + parts[1];
                    }
                }
            }, true);

            // Double click on table rows opens DCP contact detail
            document.addEventListener('dblclick', function (e) {
                const row = e.target.closest('tr');
                if (row) {
                    const link = row.querySelector('a[href*="/edit/"]');
                    if (link && link.href) {
                        e.preventDefault();
                        e.stopPropagation();
                        const parts = link.href.split(/\/edit\//);
                        if (parts[1]) {
                            window.location.href = targetBase + '/' + parts[1];
                        }
                    }
                }
            }, true);

            // Safely observe ONLY #contact_list table mutations with debouncing (NEVER document.body)
            let enrichTimer = null;
            function debouncedEnrich() {
                if (enrichTimer) clearTimeout(enrichTimer);
                enrichTimer = setTimeout(() => {
                    enrichTableRows();
                }, 60);
            }

            // Hook DataTables draw event
            if (typeof $ !== 'undefined') {
                $(document).on('draw.dt', '#contact_list', function () {
                    debouncedEnrich();
                });
            }

            // Target specifically the table element only
            const tableEl = document.getElementById('contact_list');
            if (tableEl) {
                const observer = new MutationObserver(function (mutations) {
                    let hasRowChange = false;
                    for (const m of mutations) {
                        if (m.target && m.target.closest && m.target.closest('#contact_list')) {
                            hasRowChange = true;
                            break;
                        }
                    }
                    if (hasRowChange) debouncedEnrich();
                });
                observer.observe(tableEl, { childList: true });
            }

            // Cleansing Data Modal & Batch Enrichment
            const cleansingModalEl = document.getElementById('modalCleansingData');
            let cleansingModal = null;
            if (cleansingModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                cleansingModal = new bootstrap.Modal(cleansingModalEl);
            }

            if (btnCleansingData) {
                btnCleansingData.addEventListener('click', function () {
                    // Auto-select all manual contacts currently on screen if none checked
                    if (selectedCleansingIds.size === 0) {
                        const checkboxes = document.querySelectorAll('.manual-cleansing-checkbox');
                        checkboxes.forEach(chk => {
                            chk.checked = true;
                            const cId = chk.dataset.contactId;
                            const cName = chk.dataset.contactName;
                            if (cId) {
                                selectedCleansingIds.add(cId);
                                cleansingContactNames[cId] = cName;
                            }
                        });
                        updateCleansingBadge();
                    }

                    // Reset parameter options so ONLY "Keaktifan Nomor" is checked by default
                    document.querySelectorAll('.cleansing-option-check').forEach(chk => {
                        chk.checked = (chk.value === 'network');
                    });
                    const btnToggleParamsInit = document.getElementById('btnToggleAllCleansingParams');
                    if (btnToggleParamsInit) btnToggleParamsInit.innerText = 'Pilih Semua';

                    renderCleansingModalList();
                    resetCleansingProgress();
                    if (cleansingModal) {
                        cleansingModal.show();
                    } else if (cleansingModalEl && typeof bootstrap !== 'undefined') {
                        new bootstrap.Modal(cleansingModalEl).show();
                    }
                });
            }

            function renderCleansingModalList() {
                const listEl = document.getElementById('modalCleansingContactsList');
                const countText = document.getElementById('modalCleansingCountText');
                if (!listEl) return;

                listEl.innerHTML = '';
                const ids = Array.from(selectedCleansingIds);
                if (countText) countText.innerText = ids.length;

                if (ids.length === 0) {
                    listEl.innerHTML = '<div class="text-muted text-center py-3 fs-12"><i class="ri-checkbox-blank-circle-line me-1"></i>Belum ada kontak yang dipilih. Centang checkbox pada tabel Manual CRM terlebih dahulu.</div>';
                    return;
                }

                const wrapper = document.createElement('div');
                wrapper.className = 'd-flex flex-wrap gap-2';

                ids.forEach(id => {
                    const name = cleansingContactNames[id] || 'Contact #' + id;
                    const initial = name.charAt(0).toUpperCase();
                    const item = document.createElement('div');
                    item.className = 'd-flex align-items-center gap-2 p-2 bg-white rounded-2 border shadow-xs';
                    item.innerHTML = `
                        <span class="avatar avatar-xs bg-warning-transparent text-warning fw-bold rounded-circle">${initial}</span>
                        <span class="fw-medium fs-12 text-dark">${name}</span>
                        <span class="badge bg-light text-muted border fs-10 ms-1">Manual CRM</span>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 text-decoration-none btn-remove-cleansing-contact" data-id="${id}" title="Hapus dari daftar">
                            <i class="ri-close-line"></i>
                        </button>
                    `;
                    wrapper.appendChild(item);
                });

                listEl.appendChild(wrapper);

                listEl.querySelectorAll('.btn-remove-cleansing-contact').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const remId = this.dataset.id;
                        selectedCleansingIds.delete(remId);
                        const chk = document.querySelector(`.manual-cleansing-checkbox[data-contact-id="${remId}"]`);
                        if (chk) chk.checked = false;
                        updateCleansingBadge();
                        renderCleansingModalList();
                    });
                });
            }

            const btnClearCleansing = document.getElementById('btnClearSelectedCleansing');
            if (btnClearCleansing) {
                btnClearCleansing.addEventListener('click', function () {
                    selectedCleansingIds.clear();
                    document.querySelectorAll('.manual-cleansing-checkbox').forEach(chk => chk.checked = false);
                    updateCleansingBadge();
                    renderCleansingModalList();
                });
            }

            // Simple Cleansing Parameter Checks Handlers (like Request Enrich)
            const btnToggleParams = document.getElementById('btnToggleAllCleansingParams');
            if (btnToggleParams) {
                btnToggleParams.addEventListener('click', function () {
                    const checkboxes = document.querySelectorAll('.cleansing-option-check');
                    const hasUnchecked = Array.from(checkboxes).some(chk => !chk.checked);
                    checkboxes.forEach(chk => {
                        chk.checked = hasUnchecked;
                    });
                    btnToggleParams.innerText = hasUnchecked ? 'Batal Pilih Semua' : 'Pilih Semua';
                });
            }

            document.querySelectorAll('.cleansing-option-check').forEach(chk => {
                chk.addEventListener('change', function () {
                    if (btnToggleParams) {
                        const allChecked = Array.from(document.querySelectorAll('.cleansing-option-check')).every(c => c.checked);
                        btnToggleParams.innerText = allChecked ? 'Batal Pilih Semua' : 'Pilih Semua';
                    }
                });
            });

            const btnConfirmBatch = document.getElementById('btnConfirmBatchCleansing');
            if (btnConfirmBatch) {
                btnConfirmBatch.addEventListener('click', async function () {
                    const ids = Array.from(selectedCleansingIds);
                    if (ids.length === 0) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Pilih Kontak',
                                html: '<p class="text-muted fs-13 mb-0">Silakan pilih setidaknya 1 kontak manual untuk di-cleansing & enrich.</p>',
                                confirmButtonColor: '#fe7d00',
                                confirmButtonText: 'Tutup'
                            });
                        }
                        return;
                    }

                    const checkedParams = Array.from(document.querySelectorAll('.cleansing-option-check:checked')).map(el => el.value);
                    if (checkedParams.length === 0) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Parameter Belum Dipilih',
                                html: '<p class="text-muted fs-13 mb-0">Pilih setidaknya 1 parameter cleansing / pengecekan telco sebelum melanjutkan.</p>',
                                confirmButtonColor: '#fe7d00',
                                confirmButtonText: 'Tutup'
                            });
                        }
                        return;
                    }

                    btnConfirmBatch.disabled = true;
                    const btnCancel = document.getElementById('btnCancelBatchCleansing');
                    if (btnCancel) btnCancel.disabled = true;

                    const progressBox = document.getElementById('batchCleansingProgressBox');
                    const progressBar = document.getElementById('batchCleansingProgressBar');
                    const progressText = document.getElementById('batchCleansingProgressText');
                    const progressPct = document.getElementById('batchCleansingProgressPct');

                    if (progressBox) progressBox.classList.remove('d-none');
                    if (progressBar) progressBar.style.width = '25%';
                    if (progressPct) progressPct.innerText = '25%';

                    // Stage 1 message
                    if (checkedParams.includes('format') || checkedParams.includes('network')) {
                        progressText.innerHTML = '<span class="spinner-border spinner-border-sm text-warning me-1"></span>Standardisasi E.164 (+62) & verifikasi keaktifan nomor MSISDN (HLR)...';
                    } else {
                        progressText.innerHTML = '<span class="spinner-border spinner-border-sm text-warning me-1"></span>Menyiapkan koneksi Telco Provider Gateway...';
                    }

                    await new Promise(r => setTimeout(r, 650));

                    if (progressBar) progressBar.style.width = '65%';
                    if (progressPct) progressPct.innerText = '65%';

                    // Stage 2 message
                    if (checkedParams.includes('credit_score') || checkedParams.includes('gambling')) {
                        progressText.innerHTML = '<span class="spinner-border spinner-border-sm text-primary me-1"></span>Scoring Kredit Finansial & screening risiko/indikator judi online...';
                    } else {
                        progressText.innerHTML = '<span class="spinner-border spinner-border-sm text-primary me-1"></span>Memverifikasi konsensus & profil subscriber...';
                    }

                    await new Promise(r => setTimeout(r, 750));

                    if (progressBar) progressBar.style.width = '85%';
                    if (progressPct) progressPct.innerText = '85%';

                    // Stage 3 message
                    if (checkedParams.includes('buying_power') || checkedParams.includes('device_location')) {
                        progressText.innerHTML = '<span class="spinner-border spinner-border-sm text-success me-1"></span>Sinkronisasi estimasi Daya Beli (SES), tipe perangkat & demografi...';
                    } else {
                        progressText.innerHTML = '<span class="spinner-border spinner-border-sm text-success me-1"></span>Menyimpan hasil Telco Intelligence ke CDP Customer Profile...';
                    }

                    let successCount = 0;
                    let failedCount = 0;
                    for (const contactId of ids) {
                        try {
                            const res = await fetch(`${enrichUrl}/${contactId}/enrich`, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(r => r.json());

                            if (res.data) {
                                rawEnrichedMap[contactId] = res.data;
                                const isFail = res.status === 'failed_enrichment' || res.data.enrichment_status === 'Failed';
                                if (isFail) {
                                    failedCount++;
                                } else {
                                    successCount++;
                                }

                                const rows = document.querySelectorAll('#contact_list tbody tr');
                                rows.forEach(r => {
                                    const link = r.querySelector('a[href*="/edit/"], a[href*="/dcp/contact/"]');
                                    if (link && link.getAttribute('href').includes(contactId)) {
                                        r.dataset.isEnriched = isFail ? 'false' : 'true';
                                        r.dataset.isFailed = isFail ? 'true' : 'false';
                                    }
                                });
                            }
                        } catch (e) {
                            console.error('Batch enrich error for contact ' + contactId, e);
                        }
                    }

                    if (progressBar) progressBar.style.width = '100%';
                    if (progressPct) progressPct.innerText = '100%';
                    if (progressText) progressText.innerHTML = '<i class="ri-check-line text-success fs-16 me-1"></i><span class="text-success fw-bold">Cleansing & Enrichment Selesai!</span>';

                    currentStats.enriched = (currentStats.enriched || 18) + successCount;
                    currentStats.manual = Math.max(0, (currentStats.manual || 1) - successCount);
                    updateBadgeCounts();

                    selectedCleansingIds.clear();
                    updateCleansingBadge();

                    await new Promise(r => setTimeout(r, 700));

                    enrichTableRows(true);

                    if (cleansingModal) cleansingModal.hide();
                    btnConfirmBatch.disabled = false;
                    if (btnCancel) btnCancel.disabled = false;
                    resetCleansingProgress();

                    if (typeof Swal !== 'undefined') {
                        const paramLabels = {
                            network: 'Keaktifan Nomor (HLR)',
                            credit_score: 'Kredit Score',
                            gambling: 'Deteksi Gambling',
                            format: 'Format E.164',
                            buying_power: 'Daya Beli (SES)',
                            device_location: 'Device & Demografi'
                        };
                        const badgesHtml = checkedParams.map(p => `<span class="badge bg-warning-transparent text-warning border border-warning border-opacity-25 me-1 mb-1 fs-11">${paramLabels[p] || p}</span>`).join(' ');

                        let resultHtml = `<p class="text-muted fs-13 mb-3">Proses Cleansing & Verifikasi Telco Gateway telah selesai diproses.</p>`;
                        resultHtml += `<div class="d-flex justify-content-center align-items-center gap-2 mb-2 flex-wrap">`;
                        resultHtml += `<span class="badge bg-success text-white px-3 py-2 fs-12"><i class="ri-check-line me-1"></i>${successCount} Kontak Valid Enriched</span>`;
                        if (failedCount > 0) {
                            resultHtml += `<span class="badge bg-danger text-white px-3 py-2 fs-12"><i class="ri-close-line me-1"></i>${failedCount} Gagal (Nomor Tidak Aktif &lt; 10 digit)</span>`;
                        }
                        resultHtml += `</div>`;
                        resultHtml += `<div class="mt-3 d-flex flex-wrap justify-content-center gap-1">${badgesHtml}</div>`;

                        Swal.fire({
                            icon: failedCount > 0 && successCount === 0 ? 'warning' : 'success',
                            title: 'Data Cleansing Selesai!',
                            html: resultHtml,
                            confirmButtonColor: '#fe7d00',
                            confirmButtonText: 'Tutup'
                        });
                    }
                });
            }

            function resetCleansingProgress() {
                const box = document.getElementById('batchCleansingProgressBox');
                if (box) box.classList.add('d-none');
                const bar = document.getElementById('batchCleansingProgressBar');
                if (bar) bar.style.width = '0%';
                const pct = document.getElementById('batchCleansingProgressPct');
                if (pct) pct.innerText = '0%';
                const text = document.getElementById('batchCleansingProgressText');
                if (text) text.innerHTML = '<span class="spinner-border spinner-border-sm text-warning me-1"></span>Memvalidasi MSISDN ke Telco Gateway...';
            }

            enrichTableRows();
        });
    </script>
    @endpush

    <x-sunny-ai-chat />

</x-core::page.list>
