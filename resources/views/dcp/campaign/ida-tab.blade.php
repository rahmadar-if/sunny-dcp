<div class="row g-3">
    <!-- SECTION 1: Target & Filter Summary -->
    <div class="col-12">
        <div class="card custom-card shadow-sm mb-3">
            <div class="card-header justify-content-between d-flex align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <button type="button" class="btn btn-primary btn-sm" id="btnOpenIdaFilter">
                        + Configure Target Filter
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" id="btnSimulateConsent">
                        Simulate Customer Consent
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="btnResetSimulation">
                        Remove Simulated Customers
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
                                    No consent responses received yet. Click "Simulate Customer Consent" to test customer response flow.
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
        const modalEl = document.getElementById('idaCampaignFilterModal');
        if (!modalEl) return;

        let filterModal = null;
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            filterModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        }

        const btnOpenFilter = document.getElementById('btnOpenIdaFilter');
        const filterForm = document.getElementById('idaCampaignFilterForm');
        const tableBody = document.getElementById('idaConsentedTableBody');

        if (btnOpenFilter) {
            btnOpenFilter.addEventListener('click', function(e) {
                e.preventDefault();
                if (filterModal) {
                    filterModal.show();
                } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    new bootstrap.Modal(modalEl).show();
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
            document.getElementById('idaEstimatedAudience').innerText = Number(config.estimated_audience || 0).toLocaleString();
            document.getElementById('idaDispatchedCount').innerText = Number(config.estimated_audience || 0).toLocaleString();
            document.getElementById('idaConsentCount').innerText = Number(config.consent_count || 0).toLocaleString();

            const rate = (config.estimated_audience > 0 && config.consent_count > 0)
                ? ((config.consent_count / config.estimated_audience) * 100).toFixed(2)
                : '0.00';
            document.getElementById('idaConsentRate').innerText = `${rate}%`;

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
                if (filters.gender && filters.gender !== 'All') {
                    appendFilterBadge(filterContainer, `Gender: ${filters.gender}`);
                    hasAny = true;
                }
                if (filters.age_min || filters.age_max) {
                    const min = filters.age_min || '18';
                    const max = filters.age_max || '80';
                    appendFilterBadge(filterContainer, `Age: ${min}-${max}`);
                    hasAny = true;
                }
                if (filters.residential_area && filters.residential_area.length) {
                    appendFilterBadge(filterContainer, `Area: ${filters.residential_area.join(', ')}`);
                    hasAny = true;
                }
                if (filters.city && filters.city.length) {
                    appendFilterBadge(filterContainer, `City: ${filters.city.join(', ')}`);
                    hasAny = true;
                }
                if (filters.job_workplace) {
                    appendFilterBadge(filterContainer, `Job: ${filters.job_workplace}`);
                    hasAny = true;
                }
                if (filters.top_application && filters.top_application.length) {
                    appendFilterBadge(filterContainer, `App: ${filters.top_application.join(', ')}`);
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
                            No consent responses received yet. Click "Simulate Customer Consent" to test customer response flow.
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

        if (filterForm) {
            filterForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(filterForm);

                fetch(`{{ url('dcp/campaign/ida') }}/${blastId}/apply-filter`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        if (filterModal) filterModal.hide();
                        renderConfig(res.data.config, res.data.consented_profiles);

                        // Otomatis jalankan simulate customer consent
                        setTimeout(() => {
                            triggerConsentSimulation();
                        }, 500);
                    }
                })
                .catch(err => console.error(err));
            });
        }

        // SIMULATE CUSTOMER CONSENT (Streamed 1 by 1 with random delay 1-2s)
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
                    alert(json.message || 'Simulation failed');
                    btnSimulate.disabled = false;
                    btnSimulate.innerText = 'Simulate Customer Consent';
                    return;
                }

                const newCandidates = json.data.new_candidates || [];
                const config = json.data.config;
                const estimated = Number(config.estimated_audience || 14630);

                if (newCandidates.length === 0) {
                    btnSimulate.disabled = false;
                    btnSimulate.innerText = 'Simulate Customer Consent';
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
                btnSimulate.innerText = 'Simulate Customer Consent';
            } catch (err) {
                console.error('Consent simulation error:', err);
                btnSimulate.disabled = false;
                btnSimulate.innerText = 'Simulate Customer Consent';
            }
        }

        if (btnSimulate) {
            btnSimulate.addEventListener('click', triggerConsentSimulation);
        }

        // REMOVE / RESET SIMULATED CUSTOMER LIST
        const btnReset = document.getElementById('btnResetSimulation');
        if (btnReset) {
            btnReset.addEventListener('click', function () {
                if (!confirm('Are you sure you want to remove all simulated customer consent records?')) {
                    return;
                }

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
                    btnReset.innerText = 'Remove Simulated Customers';
                    if (res.status === 'success') {
                        document.getElementById('idaConsentCount').innerText = '0';
                        document.getElementById('idaConsentRate').innerText = '0.00%';
                        const countBadge = document.getElementById('consentedTableCountBadge');
                        if (countBadge) countBadge.innerText = '0 records';

                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted" id="idaEmptyStateRow">
                                    No consent responses received yet. Click "Simulate Customer Consent" to test customer response flow.
                                </td>
                            </tr>
                        `;
                    }
                })
                .catch(err => {
                    btnReset.disabled = false;
                    btnReset.innerText = 'Remove Simulated Customers';
                    console.error('Reset simulation error:', err);
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
                        alert(res.message);
                    } else {
                        alert(res.message || 'Failed to push audience.');
                    }
                })
                .catch(err => {
                    btnPush.disabled = false;
                    btnPush.innerText = 'Push to Main Audience';
                    console.error(err);
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
