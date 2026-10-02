<!-- CUSTOMER DETAIL DRAWER (CDP ENRICHMENT INSIGHTS) -->
<div class="offcanvas offcanvas-end shadow-lg" tabindex="-1" id="contactDetailOffcanvas" style="width: 480px;" aria-labelledby="contactDetailOffcanvasLabel">
    <div class="offcanvas-header border-bottom py-3 px-4">
        <div>
            <h5 class="offcanvas-title fw-bold mb-0 text-dark" id="drawerContactName">Customer Name</h5>
            <span class="fs-13 text-muted" id="drawerContactPhone">0815xxxxxxx</span>
            <span class="badge bg-primary-transparent text-primary ms-2 fs-10" id="drawerEnrichmentStatusBadge">CDP Enriched</span>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-4">
        <!-- Manual Contact Callout (Only shown for non-enriched manual contacts) -->
        <div id="drawerManualAlert" class="alert alert-info border-0 shadow-none d-none mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="ri-information-line fs-18"></i>
                <div class="fs-12">
                    <strong>Manual CRM Contact</strong><br>
                    Data ini diinput manual oleh user dan belum dilakukan enrichment melalui jaringan telco/CDP.
                </div>
            </div>
        </div>

        <div id="drawerEnrichedContent">
            <!-- Section 1: Customer Profile Data -->
            <div class="mb-4">
                <h6 class="fs-11 text-uppercase fw-bold text-muted mb-2 letter-spacing-1">Customer Profile Data</h6>
                <div class="card custom-card bg-light border-0 shadow-none mb-0">
                    <div class="card-body p-3">
                        <div class="row g-2 fs-12">
                            <div class="col-5 text-muted">Company:</div>
                            <div class="col-7 fw-semibold text-dark" id="drawerContactCompany">-</div>
                            
                            <div class="col-5 text-muted">Job Title:</div>
                            <div class="col-7 fw-semibold text-dark" id="drawerContactJobTitle">-</div>
                            
                            <div class="col-5 text-muted">Email:</div>
                            <div class="col-7 fw-semibold text-dark text-break" id="drawerContactEmail">-</div>

                            <div class="col-5 text-muted">Residential Area:</div>
                            <div class="col-7 fw-semibold text-dark" id="drawerContactResidentialArea">-</div>

                            <div class="col-5 text-muted">Social Media:</div>
                            <div class="col-7 fw-semibold text-dark text-break" id="drawerContactSocialMedia">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Behavior Data -->
            <div class="mb-4">
                <h6 class="fs-11 text-uppercase fw-bold text-muted mb-2 letter-spacing-1">Behavior Data</h6>
                <div class="card custom-card bg-light border-0 shadow-none mb-0">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <span class="fs-11 text-muted d-block mb-1">Top Application:</span>
                            <div class="d-flex flex-wrap gap-1" id="drawerContactTopApps"></div>
                        </div>
                        <div class="mb-2">
                            <span class="fs-11 text-muted d-block mb-1">Frequently Visited Places:</span>
                            <div class="d-flex flex-wrap gap-1" id="drawerContactVisitedPlaces"></div>
                        </div>
                        <div class="mb-2">
                            <span class="fs-11 text-muted d-block mb-1">Most Purchased Products:</span>
                            <div class="d-flex flex-wrap gap-1" id="drawerContactProducts"></div>
                        </div>
                        <div class="row g-2 fs-12 pt-2 border-top mt-2">
                            <div class="col-5 text-muted">Phone & Device Type:</div>
                            <div class="col-7 fw-semibold text-dark" id="drawerContactDevice">-</div>

                            <div class="col-5 text-muted">Buying Power:</div>
                            <div class="col-7 fw-semibold text-dark" id="drawerContactBuyingPower">-</div>

                            <div class="col-5 text-muted">Competitor Usage:</div>
                            <div class="col-7 fw-semibold text-dark" id="drawerContactCarrier">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Eligibility Check -->
            <div class="mb-4">
                <h6 class="fs-11 text-uppercase fw-bold text-muted mb-2 letter-spacing-1">Eligibility Check</h6>
                <div class="card custom-card bg-light border-0 shadow-none mb-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 text-muted">Credit Score:</span>
                            <span class="fw-bold fs-16 text-dark" id="drawerContactCreditScore">810</span>
                        </div>
                        <div class="progress mb-3" style="height: 5px;">
                            <div id="drawerContactCreditBar" class="progress-bar bg-warning" role="progressbar" style="width: 85%;"></div>
                        </div>

                        <div class="row g-2 fs-12">
                            <div class="col-6 text-muted">Payment History:</div>
                            <div class="col-6 fw-semibold text-dark" id="drawerContactPaymentHistory">Smooth</div>

                            <div class="col-6 text-muted">Fraud Risk:</div>
                            <div class="col-6 fw-semibold text-success" id="drawerContactFraudRisk">Low</div>

                            <div class="col-6 text-muted">Gambling Indicator:</div>
                            <div class="col-6 fw-semibold text-success" id="drawerContactGambling">Clean</div>

                            <div class="col-6 text-muted">Blacklist:</div>
                            <div class="col-6 fw-semibold text-success" id="drawerContactBlacklist">Clean</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 pt-2">
            <button type="button" class="btn btn-outline-primary py-2" data-bs-dismiss="offcanvas">Close</button>
        </div>
    </div>
</div>
