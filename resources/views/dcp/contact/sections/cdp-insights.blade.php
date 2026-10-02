<div class="row g-3">
    @if(!$cdpProfile)
        <!-- MANUAL CONTACT STATE -->
        <div class="col-12">
            <div class="card custom-card border-0 shadow-sm bg-light">
                <div class="card-body p-4 text-center">
                    <div class="avatar avatar-xl bg-secondary-transparent text-secondary rounded-circle mx-auto mb-3">
                        <i class="ri-user-add-line fs-24"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Manual CRM Contact</h5>
                    <p class="text-muted fs-13 mx-auto mb-3" style="max-width: 520px;">
                        Kontak <strong>{{ $data->name }}</strong> saat ini diinput manual oleh pengguna CRM dan belum terhubung dengan intelligence jaringan telco / Customer Data Platform.
                    </p>
                    <div class="d-inline-flex gap-2">
                        <span class="badge bg-secondary-transparent text-secondary border px-3 py-2 fs-12">
                            <i class="ri-shield-line me-1"></i>UU PDP Status: Standby Consent
                        </span>
                        <span class="badge bg-light text-muted border px-3 py-2 fs-12">
                            <i class="ri-refresh-line me-1"></i>Awaiting Telco Synchronization
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- TOP SUMMARY BANNER (WITHOUT RADAR ICON, DISPLAYING CONTACT'S EXACT NAME) -->
        <div class="col-12">
            <div class="card custom-card border-0 shadow-sm overflow-hidden mb-2">
                <div class="card-body p-4 bg-primary-transparent border-start border-4 border-primary">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h5 class="fw-bold text-dark mb-0">{{ $data->name }}</h5>
                                <span class="badge bg-success-transparent text-success border border-success border-opacity-25 fs-11">
                                    <i class="ri-checkbox-circle-line me-1"></i>Enriched via CDP
                                </span>
                                <span class="badge bg-primary-transparent text-primary fs-11">
                                    {{ $cdpProfile->phone_status }} Network
                                </span>
                            </div>
                            <span class="fs-12 text-muted mt-1 d-block">
                                MSISDN: <strong class="text-dark">{{ $cdpProfile->phone_number }}</strong> &bull; Carrier: <strong class="text-dark">{{ $cdpProfile->competitor_product_usage }}</strong> &bull; Compliant with UU PDP No. 27/2022
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="text-center px-3 py-2 bg-white rounded border shadow-sm">
                                <span class="fs-10 text-uppercase text-muted fw-bold d-block">Buying Power</span>
                                <span class="fs-13 fw-bold text-primary">{{ $cdpProfile->buying_power }}</span>
                            </div>
                            <div class="text-center px-3 py-2 bg-white rounded border shadow-sm">
                                <span class="fs-10 text-uppercase text-muted fw-bold d-block">Credit Score</span>
                                <span class="fs-13 fw-bold text-success">{{ $cdpProfile->credit_score }}</span>
                            </div>
                            <div class="text-center px-3 py-2 bg-white rounded border shadow-sm">
                                <span class="fs-10 text-uppercase text-muted fw-bold d-block">Device</span>
                                <span class="fs-13 fw-bold text-dark">{{ $cdpProfile->phone_device_type }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- QUICK NAVIGATION LINKS TO DEDICATED TABS -->
                    <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="fs-11 text-muted fw-semibold">Quick View Dedicated Tabs:</span>
                            <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 fs-11" onclick="document.getElementById('contact-page-tabs_cdp-tabs_campaign_history_button')?.click();">
                                <i class="ri-history-line me-1"></i>CDP Campaign History ({{ count($campaignHistory) }})
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success py-1 px-2 fs-11" onclick="document.getElementById('contact-page-tabs_cdp-tabs_enrichment_history_button')?.click();">
                                <i class="ri-shield-check-line me-1"></i>Enrichment Audit Trail ({{ count($enrichmentHistory) }})
                            </button>
                        </div>
                        <span class="fs-11 text-muted">
                            <i class="ri-shield-keyhole-line me-1 text-success"></i>Explicit Consent Verified
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3-PILLAR CDP INTELLIGENCE CARDS (STACKED VERTICALLY DOWNWARDS) -->
        <!-- PILLAR 1: CUSTOMER PROFILE DATA -->
        <div class="col-12">
            <div class="card custom-card shadow-sm mb-0 border">
                <div class="card-header bg-light py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-user-shared-line text-primary fs-18"></i>
                        <h6 class="fw-bold mb-0 text-dark fs-13 text-uppercase letter-spacing-1">Customer Profile Data</h6>
                    </div>
                    <span class="badge bg-primary-transparent text-primary fs-11">Pillar 1 &bull; Identity & Demographics</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 fs-13">
                        <div class="col-md-4 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Company / Workplace</span>
                            <span class="fw-bold text-dark">{{ $cdpProfile->company ?? '-' }}</span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Job Title / Role</span>
                            <span class="fw-bold text-dark">{{ $cdpProfile->job_title ?? '-' }}</span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Gender & Age</span>
                            <span class="fw-bold text-dark">{{ $cdpProfile->gender ?? 'Unknown' }}, {{ $cdpProfile->age ?? '-' }} thn</span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Residential Area & City</span>
                            <span class="fw-bold text-dark">{{ $cdpProfile->city ?? '' }}, {{ $cdpProfile->residential_area ?? '-' }}</span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Email Address</span>
                            <span class="fw-bold text-dark text-break">{{ $cdpProfile->email ?? '-' }}</span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">MSISDN / Mobile Phone</span>
                            <span class="fw-bold text-primary font-monospace">{{ $cdpProfile->phone_number ?? '-' }}</span>
                        </div>
                        <div class="col-12">
                            <span class="text-muted fs-12 d-block mb-1">Social Media Profiles</span>
                            <div class="fw-semibold text-dark">
                                @if(is_array($cdpProfile->social_media))
                                    @forelse(array_filter($cdpProfile->social_media) as $sm)
                                        <span class="badge bg-light text-dark border me-1">{{ $sm }}</span>
                                    @empty
                                        <span class="text-muted fs-12">-</span>
                                    @endforelse
                                @else
                                    {{ $cdpProfile->social_media ?? '-' }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PILLAR 2: BEHAVIOR DATA -->
        <div class="col-12">
            <div class="card custom-card shadow-sm mb-0 border">
                <div class="card-header bg-light py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-compass-3-line text-info fs-18"></i>
                        <h6 class="fw-bold mb-0 text-dark fs-13 text-uppercase letter-spacing-1">Behavior Data</h6>
                    </div>
                    <span class="badge bg-info-transparent text-info fs-11">Pillar 2 &bull; Lifestyle & App Footprint</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <span class="fs-12 text-muted fw-semibold d-block mb-2">
                                <i class="ri-apps-line me-1 text-primary"></i>Top Applications
                            </span>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse((array)($cdpProfile->top_applications ?? []) as $app)
                                    <span class="badge bg-light text-dark border fs-12 py-1 px-2">{{ $app }}</span>
                                @empty
                                    <span class="text-muted fs-12">-</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-4">
                            <span class="fs-12 text-muted fw-semibold d-block mb-2">
                                <i class="ri-map-pin-line me-1 text-danger"></i>Frequently Visited Places
                            </span>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse((array)($cdpProfile->frequently_visited_places ?? []) as $place)
                                    <span class="badge bg-light text-dark border fs-12 py-1 px-2">{{ $place }}</span>
                                @empty
                                    <span class="text-muted fs-12">-</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-4">
                            <span class="fs-12 text-muted fw-semibold d-block mb-2">
                                <i class="ri-shopping-bag-line me-1 text-success"></i>Most Purchased Products
                            </span>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse((array)($cdpProfile->most_purchased_products ?? []) as $prod)
                                    <span class="badge bg-light text-dark border fs-12 py-1 px-2">{{ $prod }}</span>
                                @empty
                                    <span class="text-muted fs-12">-</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 fs-13 pt-3 mt-3 border-top">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted fs-12">Hardware Signature / Device:</span>
                                <span class="fw-bold text-dark"><i class="ri-smartphone-line me-1 text-muted"></i>{{ $cdpProfile->phone_device_type ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted fs-12">Carrier & Network Usage:</span>
                                <span class="fw-bold text-dark"><i class="ri-signal-tower-line me-1 text-muted"></i>{{ $cdpProfile->competitor_product_usage ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PILLAR 3: ELIGIBILITY CHECK -->
        <div class="col-12">
            <div class="card custom-card shadow-sm mb-0 border">
                <div class="card-header bg-light py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-shield-check-line text-success fs-18"></i>
                        <h6 class="fw-bold mb-0 text-dark fs-13 text-uppercase letter-spacing-1">Eligibility Check</h6>
                    </div>
                    <span class="badge bg-success-transparent text-success fs-11">Pillar 3 &bull; Credit Score & Risk Scoring</span>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-4">
                            <span class="fs-12 text-muted fw-semibold d-block">Calculated Telco Credit Score:</span>
                            <div class="d-flex align-items-baseline gap-2 mt-1">
                                <span class="fw-bold fs-24 text-dark">{{ $cdpProfile->credit_score ?? 750 }}</span>
                                <span class="fs-12 text-muted">/ 850 Max Score</span>
                                <span class="badge bg-success-transparent text-success fs-11 ms-2">High Reliability</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            @php
                                $score = $cdpProfile->credit_score ?? 750;
                                $pct = min(100, max(10, (($score - 300) / 550) * 100));
                                $color = $score >= 750 ? 'bg-success' : ($score >= 600 ? 'bg-primary' : 'bg-warning');
                            @endphp
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $pct }}%;" aria-valuenow="{{ $score }}" aria-valuemin="300" aria-valuemax="850"></div>
                            </div>
                            <div class="d-flex justify-content-between fs-11 text-muted mt-1">
                                <span>300 (Poor)</span>
                                <span>600 (Fair)</span>
                                <span>750+ (Excellent)</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 fs-13 pt-3 border-top">
                        <div class="col-md-3 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Payment History</span>
                            <span class="fw-bold text-dark"><i class="ri-checkbox-circle-fill text-success me-1"></i>{{ $cdpProfile->payment_history ?? 'Smooth' }}</span>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Fraud Risk Level</span>
                            <span class="fw-bold text-success"><i class="ri-shield-check-line me-1"></i>{{ $cdpProfile->fraud_risk ?? 'Low Risk' }}</span>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Gambling Activity Indicator</span>
                            <span class="fw-bold {{ $cdpProfile->gambling_indicator ? 'text-danger' : 'text-success' }}">
                                <i class="{{ $cdpProfile->gambling_indicator ? 'ri-alert-line' : 'ri-check-line' }} me-1"></i>
                                {{ $cdpProfile->gambling_indicator ? 'Detected' : 'Clean / None' }}
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <span class="text-muted fs-12 d-block mb-1">Telco Blacklist Status</span>
                            <span class="fw-bold {{ $cdpProfile->blacklist_status ? 'text-danger' : 'text-success' }}">
                                <i class="{{ $cdpProfile->blacklist_status ? 'ri-close-circle-line' : 'ri-check-line' }} me-1"></i>
                                {{ $cdpProfile->blacklist_status ? 'Blacklisted' : 'Clean' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
