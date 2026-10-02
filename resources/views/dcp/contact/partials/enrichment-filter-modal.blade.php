<!-- MODAL FOR REQUEST TELCO DATA ENRICHMENT -->
<div class="modal fade" id="contactEnrichmentFilterModal" tabindex="-1" aria-labelledby="contactEnrichmentFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h6 class="modal-title fw-bold text-dark mb-0 d-flex align-items-center gap-2" id="contactEnrichmentFilterModalLabel">
                        <i class="ri-radar-line text-primary fs-18"></i>
                        Request Telco Data Enrichment
                    </h6>
                    <span class="fs-12 text-muted">Synchronize target subscriber demographic, device, and behavioral intelligence from Telco Provider Gateway</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="contactEnrichmentFilterForm">
                <div class="modal-body p-4">
                    <!-- Provider Sync Banner -->
                    <div class="alert alert-primary alert-dismissible d-flex align-items-center gap-2 mb-3 py-2 px-3 fs-12 border-primary border-opacity-25" role="alert">
                        <i class="ri-information-line fs-16 text-primary flex-shrink-0"></i>
                        <div>
                            <strong>Telco Gateway Integration Active:</strong> Select target criteria below to query carrier database and enrich matched CRM contacts with real-time telco intelligence.
                        </div>
                    </div>

                    <!-- Sync Loading Simulation Overlay (Hidden by default) -->
                    <div id="enrichmentSyncProgressBox" class="card custom-card bg-primary-transparent border border-primary border-opacity-25 mb-3 d-none">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-12 fw-bold text-primary d-flex align-items-center gap-2" id="syncProgressText">
                                    <span class="spinner-border spinner-border-sm text-primary"></span>
                                    <span>Connecting to Telco Provider Gateway...</span>
                                </span>
                                <span class="badge bg-primary text-white fs-11" id="syncProgressPct">35%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="syncProgressBar" role="progressbar" style="width: 35%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Vertical Accordion Layout -->
                    <div class="accordion d-flex flex-column gap-3" id="contactEnrichmentFilterAccordion">
                        
                        <!-- PILLAR 1: CUSTOMER PROFILE DATA -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none">
                            <h2 class="accordion-header" id="cHeadingCustomerProfile">
                                <button class="accordion-button fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#cCollapseCustomerProfile" aria-expanded="true" aria-controls="cCollapseCustomerProfile">
                                    Customer Profile Data
                                </button>
                            </h2>
                            <div id="cCollapseCustomerProfile" class="accordion-collapse collapse show" data-bs-parent="#contactEnrichmentFilterAccordion" aria-labelledby="cHeadingCustomerProfile">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Gender -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Gender</label>
                                            <div class="d-flex align-items-center gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" value="All" id="cGenderAll" checked>
                                                    <label class="form-check-label fs-13" for="cGenderAll">All</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" value="Male" id="cGenderMale">
                                                    <label class="form-check-label fs-13" for="cGenderMale">Male</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" value="Female" id="cGenderFemale">
                                                    <label class="form-check-label fs-13" for="cGenderFemale">Female</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Age Range -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Age Range</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="number" class="form-control form-control-sm" name="age_min" id="cFilterAgeMin" placeholder="Min" min="18" max="80">
                                                <span class="text-muted">-</span>
                                                <input type="number" class="form-control form-control-sm" name="age_max" id="cFilterAgeMax" placeholder="Max" min="18" max="80">
                                                <span class="fs-12 text-muted">Years</span>
                                            </div>
                                        </div>

                                        <!-- Residential Area -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Residential Area</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="residential_area[]" value="High Class" id="cResHigh">
                                                    <label class="form-check-label fs-13" for="cResHigh">High Class</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="residential_area[]" value="Middle Class" id="cResMid">
                                                    <label class="form-check-label fs-13" for="cResMid">Middle Class</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="residential_area[]" value="Low Class" id="cResLow">
                                                    <label class="form-check-label fs-13" for="cResLow">Low Class</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Region / City -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Region / City</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Jakarta" id="cCityJkt">
                                                    <label class="form-check-label fs-13" for="cCityJkt">Jakarta</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Surabaya" id="cCitySby">
                                                    <label class="form-check-label fs-13" for="cCitySby">Surabaya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Bandung" id="cCityBdg">
                                                    <label class="form-check-label fs-13" for="cCityBdg">Bandung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Medan" id="cCityMdn">
                                                    <label class="form-check-label fs-13" for="cCityMdn">Medan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Bali" id="cCityBali">
                                                    <label class="form-check-label fs-13" for="cCityBali">Bali</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 2: BEHAVIOR DATA -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none">
                            <h2 class="accordion-header" id="cHeadingBehavior">
                                <button class="accordion-button collapsed fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#cCollapseBehavior" aria-expanded="false" aria-controls="cCollapseBehavior">
                                    Behavior Data
                                </button>
                            </h2>
                            <div id="cCollapseBehavior" class="accordion-collapse collapse" data-bs-parent="#contactEnrichmentFilterAccordion" aria-labelledby="cHeadingBehavior">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Buying Power -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Buying Power</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="Ultra High" id="cBpUltra">
                                                    <label class="form-check-label fs-13" for="cBpUltra">Ultra High</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="High" id="cBpHigh">
                                                    <label class="form-check-label fs-13" for="cBpHigh">High</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="Medium" id="cBpMed">
                                                    <label class="form-check-label fs-13" for="cBpMed">Medium</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="Low" id="cBpLow">
                                                    <label class="form-check-label fs-13" for="cBpLow">Low</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Top Application -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Top Applications Used</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Strava" id="cAppStrava">
                                                    <label class="form-check-label fs-13" for="cAppStrava">Strava</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Tokopedia" id="cAppToped">
                                                    <label class="form-check-label fs-13" for="cAppToped">Tokopedia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Shopee" id="cAppShopee">
                                                    <label class="form-check-label fs-13" for="cAppShopee">Shopee</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="BCA Mobile" id="cAppBca">
                                                    <label class="form-check-label fs-13" for="cAppBca">BCA Mobile</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Spotify" id="cAppSpotify">
                                                    <label class="form-check-label fs-13" for="cAppSpotify">Spotify</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Phone & Device Type -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone & Device Type</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="iPhone" id="cDevApple">
                                                    <label class="form-check-label fs-13" for="cDevApple">Apple iPhone</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="Samsung" id="cDevSamsung">
                                                    <label class="form-check-label fs-13" for="cDevSamsung">Samsung Galaxy</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="Xiaomi" id="cDevXiaomi">
                                                    <label class="form-check-label fs-13" for="cDevXiaomi">Xiaomi</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Competitor Product Usage -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Current Carrier / Competitor</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="Indosat" id="cCompIndosat">
                                                    <label class="form-check-label fs-13" for="cCompIndosat">Indosat / IM3</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="Telkomsel" id="cCompTelkomsel">
                                                    <label class="form-check-label fs-13" for="cCompTelkomsel">Telkomsel</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="XL" id="cCompXL">
                                                    <label class="form-check-label fs-13" for="cCompXL">XL Axiata</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Frequently Visited Places -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Frequently Visited Places</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="GBK Senayan" id="cPlGBK">
                                                    <label class="form-check-label fs-13" for="cPlGBK">GBK Senayan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Grand Indonesia" id="cPlGI">
                                                    <label class="form-check-label fs-13" for="cPlGI">Grand Indonesia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Senayan City" id="cPlSenci">
                                                    <label class="form-check-label fs-13" for="cPlSenci">Senayan City</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Pacific Place" id="cPlPP">
                                                    <label class="form-check-label fs-13" for="cPlPP">Pacific Place / SCBD</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 3: ELIGIBILITY CHECK -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none">
                            <h2 class="accordion-header" id="cHeadingEligibility">
                                <button class="accordion-button collapsed fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#cCollapseEligibility" aria-expanded="false" aria-controls="cCollapseEligibility">
                                    Eligibility Check
                                </button>
                            </h2>
                            <div id="cCollapseEligibility" class="accordion-collapse collapse" data-bs-parent="#contactEnrichmentFilterAccordion" aria-labelledby="cHeadingEligibility">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Min Credit Score -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Minimum Credit Score</label>
                                            <input type="number" class="form-control form-control-sm" name="min_credit_score" id="cFilterCreditScore" placeholder="e.g. 700" min="300" max="850">
                                            <span class="fs-11 text-muted">Scale 300 to 850 (Prime: 750+)</span>
                                        </div>

                                        <!-- Fraud Risk & Indicators -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Risk & Compliance Exclusion</label>
                                            <div class="d-flex flex-column gap-2 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="exclude_gambling" value="1" id="cExcludeGambling">
                                                    <label class="form-check-label fs-13" for="cExcludeGambling">Exclude Online Gambling Indicators</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="exclude_blacklist" value="1" id="cExcludeBlacklist">
                                                    <label class="form-check-label fs-13" for="cExcludeBlacklist">Exclude Telco / Financial Blacklist</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-top py-2 px-4 justify-content-between">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetContactFilterForm">Reset Form</button>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1" id="btnApplyContactFilterSubmit">
                            <i class="ri-radar-line"></i>
                            <span>Request & Sync Enrichment</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
