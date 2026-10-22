<div class="row g-3">
    <!-- SECTION 1: Target & Filter Summary -->
    <div class="col-12">
        <div class="card custom-card shadow-sm mb-3">
            <!-- Synchronized WhatsApp Template Selector Mount Point -->
            <div class="px-3 py-0 border-bottom bg-white" id="idaTemplateMountPoint" style="display: none;"></div>
            <div class="card-header justify-content-between d-flex align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <button type="button" class="btn btn-primary btn-sm" id="btnOpenIdaFilter">
                        + Configure Target Filter
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="btnOpenTestWaBlast">
                        <i class="ri-whatsapp-line me-1"></i> Send Test WhatsApp
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" id="btnSimulateConsent">
                        Customer Consent
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="btnResetSimulation">
                        Remove Customers
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnPushToAudience">
                        Push to Main Audience
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <!-- Metrics Grid -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4 col-sm-6">
                        <div class="p-3 bg-light rounded border text-center">
                            <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Estimated Target</span>
                            <h4 class="fw-bold mb-0 mt-1 text-dark" id="idaEstimatedAudience">14,630</h4>
                            <span class="fs-11 text-muted">Aggregate population</span>
                        </div>
                    </div>
                    {{-- <div class="col-md-4 col-sm-6">
                        <div class="p-3 bg-light rounded border text-center">
                            <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Messages Dispatched</span>
                            <h4 class="fw-bold mb-0 mt-1 text-primary" id="idaDispatchedCount">14,630</h4>
                            <span class="fs-11 text-muted">Via Indosat Gateway</span>
                        </div>
                    </div> --}}
                    <div class="col-md-4 col-sm-6">
                        <div class="p-3 bg-light rounded border text-center">
                            <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Customer Consent</span>
                            <h4 class="fw-bold mb-0 mt-1 text-success" id="idaConsentCount">0</h4>
                            <span class="fs-11 text-muted">Explicit consent granted</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="p-3 bg-light rounded border text-center">
                            <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Consent Rate</span>
                            <h4 class="fw-bold mb-0 mt-1 text-info" id="idaConsentRate">0%</h4>
                            <span class="fs-11 text-muted">Conversion percentage</span>
                        </div>
                    </div>
                </div>

                <!-- Active Filter List -->
                <div>
                    <span class="fs-12 text-muted fw-semibold d-block mb-2">Applied Filters:</span>
                    <div class="d-flex flex-wrap gap-2" id="idaActiveFiltersList">
                        <span class="badge bg-light text-muted border py-1 px-2 fs-11">Loading filters...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: Consented & Enriched Contacts Table -->
    <div class="col-12">
        <div class="card custom-card shadow-sm mb-0">
            <div class="card-header justify-content-between d-flex align-items-center flex-wrap gap-2">
                <div class="card-title mb-0 d-flex align-items-center gap-2">
                    <span class="fw-semibold">Consented Customers</span>
                    <span class="badge bg-success-transparent text-success" id="consentedTableCountBadge">0 records</span>
                </div>
                <span class="fs-12 text-muted">Compliant with UU PDP No. 27/2022</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="idaConsentedTable">
                        <thead class="table-light">
                            <tr>
                                <th>Customer</th>
                                <th>Demographics</th>
                                <th>Job & Company</th>
                                <th>Behavioral Insights</th>
                                <th>Eligibility & Risk</th>
                                <th class="text-center">Consent</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="idaConsentedTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted" id="idaEmptyStateRow">
                                    No consent responses received yet. Click "Customer Consent" to test customer response flow.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function initIdaTab() {
        const blastId = "{{ $data->id }}";

        function getFilterModal() {
            const mEl = document.getElementById('idaCampaignFilterModal');
            if (!mEl) return null;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                return bootstrap.Modal.getInstance(mEl) || new bootstrap.Modal(mEl);
            }
            return null;
        }

        const btnOpenFilter = document.getElementById('btnOpenIdaFilter');
        const btnOpenTestWa = document.getElementById('btnOpenTestWaBlast');
        const filterForm = document.getElementById('idaCampaignFilterForm');
        const tableBody = document.getElementById('idaConsentedTableBody');

        // Bi-directional Synchronized Template Selector between WhatsApp Template & Data Enrichment
        let originalParent = null;
        const idaMountPoint = document.getElementById('idaTemplateMountPoint');

        function syncTemplateToTab(tabName) {
            const f = document.getElementById('wa-blast-page-wa_template_detail_id');
            const col = f ? (f.closest('.col-md-7') || f.closest('.w-100')) : null;
            if (!col) return;

            if (!originalParent && col.parentElement && col.parentElement.id !== 'idaTemplateMountPoint') {
                originalParent = col.parentElement;
            }

            if (tabName === 'ida') {
                if (idaMountPoint) {
                    idaMountPoint.style.display = 'block';
                    if (!idaMountPoint.contains(col)) {
                        idaMountPoint.appendChild(col);
                        col.classList.remove('col-md-7');
                        col.classList.add('w-100');
                    }
                }
            } else if (tabName === 'wa_template') {
                if (idaMountPoint) {
                    idaMountPoint.style.display = 'none';
                }
                if (originalParent && !originalParent.contains(col)) {
                    const previewCol = originalParent.querySelector('.col-md-5');
                    if (previewCol) {
                        originalParent.insertBefore(col, previewCol);
                    } else {
                        originalParent.appendChild(col);
                    }
                    col.classList.remove('w-100');
                    col.classList.add('col-md-7');
                }
            }
        }

        // Initialize state based on active tab
        const isIdaInitiallyActive = document.querySelector('#wa-blast-page-tabs_ida')?.classList.contains('active');
        syncTemplateToTab(isIdaInitiallyActive ? 'ida' : 'wa_template');
        setTimeout(() => syncTemplateToTab(isIdaInitiallyActive ? 'ida' : 'wa_template'), 200);

        // Listen for tab switches
        const btnTabWa = document.getElementById('wa-blast-page-tabs_wa_template_button');
        const btnTabIda = document.getElementById('wa-blast-page-tabs_ida_button');

        if (btnTabIda) {
            btnTabIda.addEventListener('shown.bs.tab', () => syncTemplateToTab('ida'));
            btnTabIda.addEventListener('click', () => syncTemplateToTab('ida'));
        }
        if (btnTabWa) {
            btnTabWa.addEventListener('shown.bs.tab', () => syncTemplateToTab('wa_template'));
            btnTabWa.addEventListener('click', () => syncTemplateToTab('wa_template'));
        }

        document.addEventListener('shown.bs.tab', function(e) {
            const target = e.target.getAttribute('data-bs-target') || e.target.getAttribute('href');
            if (target === '#wa-blast-page-tabs_ida') {
                syncTemplateToTab('ida');
            } else if (target === '#wa-blast-page-tabs_wa_template') {
                syncTemplateToTab('wa_template');
            }
        });

        if (btnOpenFilter) {
            btnOpenFilter.addEventListener('click', function(e) {
                e.preventDefault();
                const m = getFilterModal();
                if (m) m.show();
            });
        }

        if (btnOpenTestWa) {
            btnOpenTestWa.addEventListener('click', function(e) {
                e.preventDefault();
                const mainTestBtn = document.getElementById('wa-blast-page-test-email');
                if (mainTestBtn) {
                    mainTestBtn.removeAttribute('disabled');
                    mainTestBtn.classList.remove('disabled');
                    mainTestBtn.click();
                } else {
                    const testModalEl = document.getElementById('wa-blast-test-wa-modal');
                    if (testModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        bootstrap.Modal.getOrCreateInstance(testModalEl).show();
                    }
                }
            });
        }

        function loadIdaConfig() {
            fetch(`{{ url('dcp/campaign/ida') }}/${blastId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    renderConfig(res.data.config, res.data.consented_profiles);
                    populateFormFromConfig(res.data.config?.filters);
                }
            })
            .catch(err => console.error('Failed to load Data Enrichment config:', err));
        }

        function renderConfig(config, profiles) {
            if (!config) return;
            const elEst = document.getElementById('idaEstimatedAudience');
            if (elEst) elEst.innerText = Number(config.estimated_audience || 0).toLocaleString();

            const elDisp = document.getElementById('idaDispatchedCount');
            if (elDisp) elDisp.innerText = Number(config.estimated_audience || 0).toLocaleString();

            const elConsent = document.getElementById('idaConsentCount');
            if (elConsent) elConsent.innerText = Number(config.consent_count || 0).toLocaleString();

            const rate = (config.estimated_audience > 0 && config.consent_count > 0)
                ? ((config.consent_count / config.estimated_audience) * 100).toFixed(2)
                : '0.00';
            const elRate = document.getElementById('idaConsentRate');
            if (elRate) elRate.innerText = `${rate}%`;

            const filterContainer = document.getElementById('idaActiveFiltersList');
            if (filterContainer) {
                filterContainer.innerHTML = '';
                const filters = config.filters || {};
                let hasAny = false;

                if (filters.name) {
                    appendFilterBadge(filterContainer, `Name: ${filters.name}`);
                    hasAny = true;
                }
                if (filters.operator && filters.operator !== 'All') {
                    appendFilterBadge(filterContainer, `Operator: ${filters.operator}`);
                    hasAny = true;
                }
                // 1. Search by Gender (Always display, including 'All')
                if (filters.gender) {
                    appendFilterBadge(filterContainer, `Gender: ${filters.gender}`);
                    hasAny = true;
                } else {
                    appendFilterBadge(filterContainer, 'Gender: All');
                    hasAny = true;
                }

                // 2. Search by Age Range (18-70 years default)
                if (filters.age_min || filters.age_max) {
                    const min = filters.age_min || '18';
                    const max = filters.age_max || '70';
                    appendFilterBadge(filterContainer, `Age: ${min}-${max} Yrs`);
                    hasAny = true;
                } else {
                    appendFilterBadge(filterContainer, 'Age: 18-70 Yrs');
                    hasAny = true;
                }

                // 3. Search by Region (City)
                if (filters.city && (Array.isArray(filters.city) ? filters.city.length : filters.city)) {
                    const cityVal = Array.isArray(filters.city) ? filters.city.join(', ') : filters.city;
                    appendFilterBadge(filterContainer, `Region: ${cityVal}`);
                    hasAny = true;
                }

                // 4. Search by Area (Dependent Sub-City / District)
                if (filters.search_by_area && (Array.isArray(filters.search_by_area) ? filters.search_by_area.length : filters.search_by_area)) {
                    const areaVal = Array.isArray(filters.search_by_area) ? filters.search_by_area.join(', ') : filters.search_by_area;
                    appendFilterBadge(filterContainer, `Area: ${areaVal}`);
                    hasAny = true;
                } else {
                    appendFilterBadge(filterContainer, 'Area: All Area');
                    hasAny = true;
                }

                // 5. Search by Interest (Full list of selected interests)
                if (filters.interest && (Array.isArray(filters.interest) ? filters.interest.length : filters.interest)) {
                    const intVal = Array.isArray(filters.interest) ? filters.interest.join(', ') : filters.interest;
                    appendFilterBadge(filterContainer, `Interests: ${intVal}`);
                    hasAny = true;
                }

                // 6. Search by Income
                if (filters.income && (Array.isArray(filters.income) ? filters.income.length : filters.income)) {
                    const incomeVal = Array.isArray(filters.income) ? filters.income.join(', ') : filters.income;
                    appendFilterBadge(filterContainer, `Income: ${incomeVal}`);
                    hasAny = true;
                }
                if (filters.banking_behavior && filters.banking_behavior.length) {
                    appendFilterBadge(filterContainer, `Banking: ${filters.banking_behavior.join(', ')}`);
                    hasAny = true;
                }
                if (filters.lifestyle && filters.lifestyle.length) {
                    appendFilterBadge(filterContainer, `Lifestyle: ${filters.lifestyle.join(', ')}`);
                    hasAny = true;
                }
                if (filters.competitor_product && filters.competitor_product.length) {
                    appendFilterBadge(filterContainer, `Competitor: ${filters.competitor_product.join(', ')}`);
                    hasAny = true;
                }
                if (filters.buying_power && filters.buying_power.length) {
                    appendFilterBadge(filterContainer, `Buying Power: ${filters.buying_power.join(', ')}`);
                    hasAny = true;
                }
                if (filters.phone_device_type && filters.phone_device_type.length) {
                    appendFilterBadge(filterContainer, `Device: ${filters.phone_device_type.join(', ')}`);
                    hasAny = true;
                }
                if (filters.preferred_banks && filters.preferred_banks.length) {
                    appendFilterBadge(filterContainer, `Bank: ${filters.preferred_banks.join(', ')}`);
                    hasAny = true;
                }
                if (filters.frequently_visited_places && filters.frequently_visited_places.length) {
                    appendFilterBadge(filterContainer, `Places: ${filters.frequently_visited_places.join(', ')}`);
                    hasAny = true;
                }
                if (filters.exclude_gambling) {
                    appendFilterBadge(filterContainer, 'No Gambling');
                    hasAny = true;
                }
                if (filters.exclude_blacklist) {
                    appendFilterBadge(filterContainer, 'No Blacklist');
                    hasAny = true;
                }
                if (filters.exclude_negative_credit) {
                    appendFilterBadge(filterContainer, 'No Bad Credit');
                    hasAny = true;
                }
                if (filters.min_credit_score) {
                    appendFilterBadge(filterContainer, `Score >= ${filters.min_credit_score}`);
                    hasAny = true;
                }

                if (!hasAny) {
                    appendFilterBadge(filterContainer, 'No specific filter applied');
                }
            }

            renderConsentedTable(profiles);
        }

        function appendFilterBadge(container, text) {
            const span = document.createElement('span');
            span.className = 'badge bg-light text-dark border py-1 px-2 fs-11';
            span.innerText = text;
            container.appendChild(span);
        }

        function populateFormFromConfig(filters) {
            if (!filters || !filterForm) return;

            if (filters.name) {
                const el = filterForm.querySelector('#fFilterName');
                if (el) el.value = filters.name;
            }
            if (filters.operator) {
                const el = filterForm.querySelector('#fFilterOperator');
                if (el) el.value = filters.operator;
            }
            if (filters.gender) {
                const el = filterForm.querySelector(`input[name="gender"][value="${filters.gender}"]`);
                if (el) el.checked = true;
            }
            if (filters.age_min) {
                const el = filterForm.querySelector('#fFilterAgeMin');
                if (el) el.value = filters.age_min;
            }
            if (filters.age_max) {
                const el = filterForm.querySelector('#fFilterAgeMax');
                if (el) el.value = filters.age_max;
            }
            if (filters.job_workplace) {
                const el = filterForm.querySelector('#fFilterJob');
                if (el) el.value = filters.job_workplace;
            }
            if (filters.city || filters.search_by_area) {
                const regArr = Array.isArray(filters.city) ? filters.city : (filters.city ? [filters.city] : []);
                const areaArr = Array.isArray(filters.search_by_area) ? filters.search_by_area : (filters.search_by_area ? [filters.search_by_area] : []);
                if (typeof window.updateIdaRegionAndArea === 'function') {
                    window.updateIdaRegionAndArea(regArr, areaArr);
                }
            }
            if (filters.interest) {
                const intArr = Array.isArray(filters.interest) ? filters.interest : [filters.interest];
                if (typeof window.updateIdaInterests === 'function') {
                    window.updateIdaInterests(intArr);
                }
            }
            if (filters.income && Array.isArray(filters.income)) {
                filters.income.forEach(inc => {
                    const chk = filterForm.querySelector(`input[name="income[]"][value="${inc}"]`);
                    if (chk) chk.checked = true;
                });
            }
            if (filters.min_credit_score) {
                const slider = filterForm.querySelector('#fCreditScoreRange');
                const badge = document.getElementById('fCreditScoreBadge');
                const hidden = document.getElementById('fMinCreditScoreInput');
                if (slider) slider.value = filters.min_credit_score;
                if (badge) badge.innerText = filters.min_credit_score;
                if (hidden) hidden.value = filters.min_credit_score;
            }
        }

        function createProfileRow(p, isAnimated) {
            const tr = document.createElement('tr');
            if (isAnimated) {
                tr.style.transition = 'background-color 0.8s ease-in-out';
                tr.style.backgroundColor = '#ecfdf5';
                setTimeout(() => {
                    tr.style.backgroundColor = '';
                }, 1800);
            }

            const hasStrava = p.top_applications && p.top_applications.includes('Strava');
            const genderLabel = p.gender ? `${p.gender}, ` : '';
            const ageLabel = p.age ? `${p.age} thn` : '';

            tr.innerHTML = `
                <td>
                    <span class="fw-semibold text-dark d-block">${p.name}</span>
                    <span class="fs-12 text-muted">${p.phone_number}</span>
                </td>
                <td>
                    <span class="d-block text-dark fs-13">${genderLabel}${ageLabel}</span>
                    <span class="fs-11 text-muted">${p.city || '-'}, ${p.residential_area || '-'}</span>
                </td>
                <td>
                    <span class="d-block text-dark fs-13">${p.job_title || '-'}</span>
                    <span class="fs-11 text-muted">${p.company || '-'}</span>
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1 align-items-center">
                        ${hasStrava ? '<span class="badge bg-light text-dark border fs-10">Strava</span>' : ''}
                        <span class="badge bg-light text-dark border fs-10">${p.phone_device_type || 'Device'}</span>
                        <span class="badge bg-light text-dark border fs-10">BP: ${p.buying_power}</span>
                    </div>
                </td>
                <td>
                    <span class="badge bg-success-transparent text-success border border-success border-opacity-25 fs-10">
                        Score: ${p.credit_score} | Clean
                    </span>
                </td>
                <td class="text-center">
                    <span class="badge bg-success text-white fs-10 py-1 px-2">
                        Yes (Consent Verified)
                    </span>
                </td>
                <td class="text-center">
                    <span class="badge bg-success-transparent text-success border border-success border-opacity-25 fs-10">
                        Enriched
                    </span>
                </td>
            `;
            return tr;
        }

        function renderConsentedTable(profiles) {
            const countBadge = document.getElementById('consentedTableCountBadge');
            if (countBadge) {
                countBadge.innerText = `${profiles ? profiles.length : 0} records`;
            }

            if (!profiles || profiles.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted" id="idaEmptyStateRow">
                            No consent responses received yet. Click "Customer Consent" to test customer response flow.
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = '';
            profiles.forEach(p => {
                const tr = createProfileRow(p, false);
                tableBody.appendChild(tr);
            });
        }

        // APPLY FILTER LOGIC (Triggered via #cBtnSubmitFilter or form submit)
        async function executeApplyFilter(e) {
            if (e && typeof e.preventDefault === 'function') {
                e.preventDefault();
            }

            const currentForm = document.getElementById('idaCampaignFilterForm');
            if (!currentForm) return;

            const submitBtn = document.getElementById('cBtnSubmitFilter');
            let originalBtnHtml = submitBtn ? submitBtn.innerHTML : 'Apply Filter';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Applying Filter...';
            }

            const formData = new FormData(currentForm);

            try {
                const res = await fetch(`{{ url('dcp/campaign/ida') }}/${blastId}/apply-filter`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const json = await res.json();

                if (json.status === 'success') {
                    const m = getFilterModal();
                    if (m) m.hide();

                    renderConfig(json.data.config, json.data.consented_profiles);
                    showSunnyAlert('Success', 'Target filter successfully applied.', 'success');
                } else {
                    showSunnyAlert('Error', json.message || 'Failed to apply filters.', 'error');
                }
            } catch (err) {
                console.error('Filter apply error:', err);
                showSunnyAlert('Error', 'An error occurred while applying filter.', 'error');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
            }
        }

        const submitBtn = document.getElementById('cBtnSubmitFilter');
        if (submitBtn) {
            submitBtn.addEventListener('click', executeApplyFilter);
        }

        if (filterForm) {
            filterForm.addEventListener('submit', executeApplyFilter);
        }

        // Event delegation on document to catch #cBtnSubmitFilter dynamically
        document.addEventListener('click', function(e) {
            const btn = e.target && e.target.closest ? e.target.closest('#cBtnSubmitFilter') : null;
            if (btn) {
                e.preventDefault();
                executeApplyFilter(e);
            }
        });

        function showSunnyAlert(title, message, icon = 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: icon,
                    title: title,
                    html: message ? `<p class="text-muted fs-13 mb-0">${message}</p>` : undefined,
                    confirmButtonColor: '#fe7d00',
                    confirmButtonText: 'OK',
                    timer: icon === 'success' ? 3000 : undefined,
                    timerProgressBar: icon === 'success'
                });
            } else if (typeof window.Helper !== 'undefined' && typeof window.Helper.successAlert === 'function' && icon === 'success') {
                window.Helper.successAlert({ title: title, message: message || '', timeout: 3000 });
            }
        }

        // CUSTOMER CONSENT (Streamed 1 by 1 with random delay 1-2s)
        const btnSimulate = document.getElementById('btnSimulateConsent');

        async function triggerConsentSimulation() {
            if (!btnSimulate) return;
            btnSimulate.disabled = true;
            btnSimulate.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Listening for consent...';

            try {
                const res = await fetch(`{{ url('dcp/campaign/ida') }}/${blastId}/simulate-consent`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();

                if (json.status !== 'success') {
                    showSunnyAlert('Error', json.message || 'Failed to get customer consent.', 'error');
                    btnSimulate.disabled = false;
                    btnSimulate.innerText = 'Customer Consent';
                    return;
                }

                const newCandidates = json.data.new_candidates || [];
                const config = json.data.config;
                const estimated = Number(config.estimated_audience || 14630);

                if (newCandidates.length === 0) {
                    btnSimulate.disabled = false;
                    btnSimulate.innerText = 'Customer Consent';
                    return;
                }

                // Remove empty state row if present
                const emptyState = document.getElementById('idaEmptyStateRow');
                if (emptyState) {
                    tableBody.innerHTML = '';
                }

                let currentCount = parseInt(document.getElementById('idaConsentCount').innerText.replace(/,/g, '')) || 0;

                for (let i = 0; i < newCandidates.length; i++) {
                    const candidate = newCandidates[i];

                    // Random interval between 1000ms and 2000ms (1-2 seconds)
                    const delay = Math.floor(Math.random() * (2000 - 1000 + 1)) + 1000;
                    btnSimulate.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span>Receiving consent (${i + 1}/${newCandidates.length})...`;

                    await new Promise(resolve => setTimeout(resolve, delay));

                    // Prepend newly consented customer row to the top of table
                    const tr = createProfileRow(candidate, true);
                    tableBody.insertBefore(tr, tableBody.firstChild);

                    // Live increment counter and rate
                    currentCount++;
                    document.getElementById('idaConsentCount').innerText = currentCount.toLocaleString();

                    const rate = estimated > 0 ? ((currentCount / estimated) * 100).toFixed(2) : '0.00';
                    document.getElementById('idaConsentRate').innerText = `${rate}%`;

                    const countBadge = document.getElementById('consentedTableCountBadge');
                    if (countBadge) {
                        countBadge.innerText = `${currentCount} records`;
                    }
                }

                btnSimulate.disabled = false;
                btnSimulate.innerText = 'Customer Consent';
            } catch (err) {
                console.error('Consent simulation error:', err);
                btnSimulate.disabled = false;
                btnSimulate.innerText = 'Customer Consent';
            }
        }

        if (btnSimulate) {
            btnSimulate.addEventListener('click', triggerConsentSimulation);
        }

        // REMOVE / RESET CUSTOMER LIST (Direct action without confirm alert)
        const btnReset = document.getElementById('btnResetSimulation');
        if (btnReset) {
            btnReset.addEventListener('click', function () {
                btnReset.disabled = true;
                btnReset.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Removing...';

                fetch(`{{ url('dcp/campaign/ida') }}/${blastId}/reset-simulation`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    btnReset.disabled = false;
                    btnReset.innerText = 'Remove Customers';
                    if (res.status === 'success') {
                        document.getElementById('idaConsentCount').innerText = '0';
                        document.getElementById('idaConsentRate').innerText = '0.00%';
                        const countBadge = document.getElementById('consentedTableCountBadge');
                        if (countBadge) countBadge.innerText = '0 records';

                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted" id="idaEmptyStateRow">
                                    No consent responses received yet. Click "Customer Consent" to test customer response flow.
                                </td>
                            </tr>
                        `;

                        showSunnyAlert('Success', 'Customer consent records have been removed.', 'success');
                    } else {
                        showSunnyAlert('Error', res.message || 'Failed to remove customer records.', 'error');
                    }
                })
                .catch(err => {
                    btnReset.disabled = false;
                    btnReset.innerText = 'Remove Customers';
                    console.error('Reset simulation error:', err);
                    showSunnyAlert('Error', 'An error occurred while removing records.', 'error');
                });
            });
        }

        // PUSH TO CRM MAIN AUDIENCE
        const btnPush = document.getElementById('btnPushToAudience');
        if (btnPush) {
            btnPush.addEventListener('click', function () {
                btnPush.disabled = true;
                btnPush.innerText = 'Pushing to Audience...';

                fetch(`{{ url('dcp/campaign/ida') }}/${blastId}/push-audience`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    btnPush.disabled = false;
                    btnPush.innerText = 'Push to Main Audience';
                    if (res.status === 'success') {
                        showSunnyAlert('Success', res.message || 'Customers pushed to main audience successfully.', 'success');
                    } else {
                        showSunnyAlert('Error', res.message || 'Failed to push audience.', 'error');
                    }
                })
                .catch(err => {
                    btnPush.disabled = false;
                    btnPush.innerText = 'Push to Main Audience';
                    console.error(err);
                    showSunnyAlert('Error', 'An error occurred while pushing to audience.', 'error');
                });
            });
        }

        loadIdaConfig();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initIdaTab);
    } else {
        initIdaTab();
    }
})();
</script>
