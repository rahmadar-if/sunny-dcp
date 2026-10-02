<!-- MODAL FILTER FOR DATA ENRICHMENT -->
<div class="modal fade" id="idaCampaignFilterModal" tabindex="-1" aria-labelledby="idaCampaignFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h6 class="modal-title fw-bold text-dark mb-0" id="idaCampaignFilterModalLabel">Filter Data Enrichment</h6>
                    <!-- Subtitle for modal context -->
                    <span class="fs-12 text-muted">Audience segmentation based on customer profiles, behavior data, and eligibility</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="idaCampaignFilterForm">
                <div class="modal-body p-4">
                    <!-- Vertical Accordion / Collapse Layout (No Tabs) -->
                    <div class="accordion d-flex flex-column gap-3" id="enrichmentFilterAccordion">
                        
                        <!-- PILLAR 1: CUSTOMER PROFILE DATA -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none">
                            <h2 class="accordion-header" id="headingCustomerProfile">
                                <button class="accordion-button fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomerProfile" aria-expanded="true" aria-controls="collapseCustomerProfile">
                                    Customer Profile Data
                                </button>
                            </h2>
                            <div id="collapseCustomerProfile" class="accordion-collapse collapse show" data-bs-parent="#enrichmentFilterAccordion" aria-labelledby="headingCustomerProfile">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Nama -->
                                        {{-- <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Name</label>
                                            <input type="text" class="form-control form-control-sm" name="name" id="fFilterName" placeholder="Search customer name">
                                        </div> --}}

                                        <!-- Phone Number & Operator -->
                                        {{-- <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone Operator</label>
                                            <select class="form-select form-select-sm" name="operator" id="fFilterOperator">
                                                <option value="All">All Operators</option>
                                                <option value="Indosat">Indosat / IM3</option>
                                                <option value="Telkomsel">Telkomsel</option>
                                                <option value="XL">XL Axiata</option>
                                            </select>
                                        </div> --}}

                                        <!-- Gender -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Gender</label>
                                            <div class="d-flex align-items-center gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" value="All" id="fGenderAll" checked>
                                                    <label class="form-check-label fs-13" for="fGenderAll">All</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" value="Male" id="fGenderMale">
                                                    <label class="form-check-label fs-13" for="fGenderMale">Male</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" value="Female" id="fGenderFemale">
                                                    <label class="form-check-label fs-13" for="fGenderFemale">Female</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Range Usia -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Age Range</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="number" class="form-control form-control-sm" name="age_min" id="fFilterAgeMin" placeholder="Min" min="18" max="80">
                                                <span class="text-muted">-</span>
                                                <input type="number" class="form-control form-control-sm" name="age_max" id="fFilterAgeMax" placeholder="Max" min="18" max="80">
                                                <span class="fs-12 text-muted">Years</span>
                                            </div>
                                        </div>

                                        <!-- Residential Area -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Residential Area</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="residential_area[]" value="High Class" id="fResHigh">
                                                    <label class="form-check-label fs-13" for="fResHigh">High Class</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="residential_area[]" value="Middle Class" id="fResMid">
                                                    <label class="form-check-label fs-13" for="fResMid">Middle Class</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="residential_area[]" value="Low Class" id="fResLow">
                                                    <label class="form-check-label fs-13" for="fResLow">Low Class</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Daerah / Kota -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Region / City</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Jakarta" id="fCityJkt">
                                                    <label class="form-check-label fs-13" for="fCityJkt">Jakarta</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Jabodetabek" id="fCityJabodetabek">
                                                    <label class="form-check-label fs-13" for="fCityJabodetabek">Jabodetabek</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Surabaya" id="fCitySby">
                                                    <label class="form-check-label fs-13" for="fCitySby">Surabaya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Bandung" id="fCityBdg">
                                                    <label class="form-check-label fs-13" for="fCityBdg">Bandung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Medan" id="fCityMdn">
                                                    <label class="form-check-label fs-13" for="fCityMdn">Medan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Bali" id="fCityBali">
                                                    <label class="form-check-label fs-13" for="fCityBali">Bali</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="city[]" value="Yogyakarta" id="fCityYog">
                                                    <label class="form-check-label fs-13" for="fCityYog">Yogyakarta</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Job & Workplace -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Job & Workplace</label>
                                            <input type="text" class="form-control form-control-sm" name="job_workplace" id="fFilterJob" placeholder="e.g. Director, Manager, Tech, Banking">
                                        </div>

                                        <!-- Social Media -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Social Media</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="instagram" id="fSocIg">
                                                    <label class="form-check-label fs-13" for="fSocIg">Instagram</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="linkedin" id="fSocLi">
                                                    <label class="form-check-label fs-13" for="fSocLi">LinkedIn</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="strava" id="fSocStrava">
                                                    <label class="form-check-label fs-13" for="fSocStrava">Strava</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="tiktok" id="fSocTt">
                                                    <label class="form-check-label fs-13" for="fSocTt">TikTok</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 2: BEHAVIOR DATA -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none">
                            <h2 class="accordion-header" id="headingBehavior">
                                <button class="accordion-button collapsed fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBehavior" aria-expanded="false" aria-controls="collapseBehavior">
                                    Behavior Data
                                </button>
                            </h2>
                            <div id="collapseBehavior" class="accordion-collapse collapse" data-bs-parent="#enrichmentFilterAccordion" aria-labelledby="headingBehavior">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Top Application -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Top Application</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Strava" id="fAppStrava">
                                                    <label class="form-check-label fs-13" for="fAppStrava">Strava</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Tokopedia" id="fAppTokopedia">
                                                    <label class="form-check-label fs-13" for="fAppTokopedia">Tokopedia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Shopee" id="fAppShopee">
                                                    <label class="form-check-label fs-13" for="fAppShopee">Shopee</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="BCA Mobile" id="fAppBCA">
                                                    <label class="form-check-label fs-13" for="fAppBCA">BCA Mobile</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Livin Mandiri" id="fAppLivin">
                                                    <label class="form-check-label fs-13" for="fAppLivin">Livin Mandiri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="top_application[]" value="Spotify" id="fAppSpotify">
                                                    <label class="form-check-label fs-13" for="fAppSpotify">Spotify</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buying Power -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Buying Power</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="Ultra High" id="fBpUltra">
                                                    <label class="form-check-label fs-13" for="fBpUltra">Ultra High</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="High" id="fBpHigh">
                                                    <label class="form-check-label fs-13" for="fBpHigh">High</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="Medium" id="fBpMed">
                                                    <label class="form-check-label fs-13" for="fBpMed">Medium</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="buying_power[]" value="Low" id="fBpLow">
                                                    <label class="form-check-label fs-13" for="fBpLow">Low</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Competitor Product Usage -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Competitor Product Usage</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="Telkomsel" id="fCompTsel">
                                                    <label class="form-check-label fs-13" for="fCompTsel">Telkomsel</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="XL" id="fCompXL">
                                                    <label class="form-check-label fs-13" for="fCompXL">XL Axiata</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="Smartfren" id="fCompSmart">
                                                    <label class="form-check-label fs-13" for="fCompSmart">Smartfren</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="IM3" id="fCompIM3">
                                                    <label class="form-check-label fs-13" for="fCompIM3">Indosat / IM3</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Phone & Device Type -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone & Device Type</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="iPhone" id="fDevApple">
                                                    <label class="form-check-label fs-13" for="fDevApple">Apple iPhone</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="Samsung" id="fDevSamsung">
                                                    <label class="form-check-label fs-13" for="fDevSamsung">Samsung Galaxy</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="Xiaomi" id="fDevXiaomi">
                                                    <label class="form-check-label fs-13" for="fDevXiaomi">Xiaomi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="Pixel" id="fDevPixel">
                                                    <label class="form-check-label fs-13" for="fDevPixel">Google Pixel</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preferred Banks -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Preferred Banks</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BCA" id="fBankBCA">
                                                    <label class="form-check-label fs-13" for="fBankBCA">BCA</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="Mandiri" id="fBankMandiri">
                                                    <label class="form-check-label fs-13" for="fBankMandiri">Bank Mandiri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="CIMB" id="fBankCIMB">
                                                    <label class="form-check-label fs-13" for="fBankCIMB">CIMB Niaga</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BRI" id="fBankBRI">
                                                    <label class="form-check-label fs-13" for="fBankBRI">BRI</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="Jago" id="fBankJago">
                                                    <label class="form-check-label fs-13" for="fBankJago">Digital Banks</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Frequently Visited Places -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Frequently Visited Places</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="GBK Senayan" id="fPlGBK">
                                                    <label class="form-check-label fs-13" for="fPlGBK">GBK Senayan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="SCBD" id="fPlSCBD">
                                                    <label class="form-check-label fs-13" for="fPlSCBD">SCBD Area</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Plaza Senayan" id="fPlPS">
                                                    <label class="form-check-label fs-13" for="fPlPS">Plaza Senayan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Grand Indonesia" id="fPlGI">
                                                    <label class="form-check-label fs-13" for="fPlGI">Grand Indonesia</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Most Purchased Products -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Most Purchased Products</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="most_purchased_products[]" value="Running Shoes" id="fProdRunning">
                                                    <label class="form-check-label fs-13" for="fProdRunning">Running Shoes & Gear</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="most_purchased_products[]" value="Smartwatch" id="fProdWatch">
                                                    <label class="form-check-label fs-13" for="fProdWatch">Smartwatch & Tech</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="most_purchased_products[]" value="Fine Dining" id="fProdDining">
                                                    <label class="form-check-label fs-13" for="fProdDining">Fine Dining & Lifestyle</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="most_purchased_products[]" value="Flights" id="fProdFlight">
                                                    <label class="form-check-label fs-13" for="fProdFlight">Travel & Flights</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 3: ELIGIBILITY CHECK -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none">
                            <h2 class="accordion-header" id="headingEligibility">
                                <button class="accordion-button collapsed fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEligibility" aria-expanded="false" aria-controls="collapseEligibility">
                                    Eligibility Check
                                </button>
                            </h2>
                            <div id="collapseEligibility" class="accordion-collapse collapse" data-bs-parent="#enrichmentFilterAccordion" aria-labelledby="headingEligibility">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Indicators & Blacklist -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Risk Exclusions</label>
                                            <div class="p-3 bg-light rounded border">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="exclude_gambling" value="1" id="fExcludeGambling">
                                                    <label class="form-check-label fs-13 fw-semibold text-dark" for="fExcludeGambling">
                                                        Exclude Gambling Indicators
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="exclude_blacklist" value="1" id="fExcludeBlacklist">
                                                    <label class="form-check-label fs-13 fw-semibold text-dark" for="fExcludeBlacklist">
                                                        Exclude Blacklist
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Credit Score -->
                                        {{-- <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Minimum Credit Score</label>
                                            <div class="p-3 bg-light rounded border">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="fs-12 text-muted">Threshold:</span>
                                                    <span class="badge bg-primary fs-12" id="fCreditScoreBadge">650</span>
                                                </div>
                                                <input type="range" class="form-range" min="300" max="850" step="10" value="650" id="fCreditScoreRange" oninput="document.getElementById('fCreditScoreBadge').innerText = this.value; document.getElementById('fMinCreditScoreInput').value = this.value;">
                                                <input type="hidden" name="min_credit_score" id="fMinCreditScoreInput" value="650">
                                            </div>
                                        </div> --}}

                                        <!-- Payment History -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Payment History</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="Smooth" id="fPaySmooth">
                                                    <label class="form-check-label fs-13" for="fPaySmooth">Smooth</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="On-time" id="fPayOntime">
                                                    <label class="form-check-label fs-13" for="fPayOntime">On-time</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="Late > 30d" id="fPayLate">
                                                    <label class="form-check-label fs-13" for="fPayLate">Late > 30 Days</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Outstanding Amount -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Outstanding Limit</label>
                                            <select class="form-select form-select-sm" name="max_outstanding" id="fFilterOutstanding">
                                                <option value="">No Limit</option>
                                                <option value="0">Zero Outstanding</option>
                                                <option value="1000000">Max Rp 1.000.000</option>
                                                <option value="5000000">Max Rp 5.000.000</option>
                                            </select>
                                        </div>

                                        <!-- Fraud Risk -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Fraud Risk Level</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fraud_risk[]" value="Low" id="fRiskLow">
                                                    <label class="form-check-label fs-13" for="fRiskLow">Low Risk</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fraud_risk[]" value="Medium" id="fRiskMed">
                                                    <label class="form-check-label fs-13" for="fRiskMed">Medium Risk</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fraud_risk[]" value="High" id="fRiskHigh">
                                                    <label class="form-check-label fs-13" for="fRiskHigh">High Risk</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Phone Status -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone Line Status</label>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="phone_status" value="Active" id="fPhoneActive">
                                                <label class="form-check-label fs-13" for="fPhoneActive">Active Lines Only</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light py-2 px-4">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4" id="cBtnSubmitFilter">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
