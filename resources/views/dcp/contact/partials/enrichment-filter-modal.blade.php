<!-- MODAL FOR REQUEST TELCO DATA ENRICHMENT -->
<div class="modal fade" id="contactEnrichmentFilterModal" tabindex="-1" aria-labelledby="contactEnrichmentFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-height: 92vh;">
        <div class="modal-content border-0 shadow d-flex flex-column overflow-hidden" style="max-height: 92vh;">
            <div class="modal-header border-bottom py-3 px-4 flex-shrink-0 bg-white">
                <div>
                    <h6 class="modal-title fw-bold text-dark mb-0 d-flex align-items-center gap-2" id="contactEnrichmentFilterModalLabel">
                        <i class="ri-radar-line text-primary fs-18"></i>
                        Request Telco Data Enrichment
                    </h6>
                    <span class="fs-12 text-muted">Synchronize target subscriber demographic, device, and behavioral intelligence from Telco Provider Gateway</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="contactEnrichmentFilterForm" class="d-flex flex-column flex-grow-1 overflow-hidden m-0 p-0" style="min-height: 0;">
                <div class="modal-body p-4 overflow-y-auto flex-grow-1" style="max-height: calc(92vh - 130px);">
                    <!-- Provider Sync Banner -->
                    {{-- <div class="alert alert-primary alert-dismissible d-flex align-items-center gap-2 mb-3 py-2 px-3 fs-12 border-primary border-opacity-25" role="alert">
                        <i class="ri-information-line fs-16 text-primary flex-shrink-0"></i>
                        <div>
                            <strong>Telco Gateway Integration Active:</strong> Select target criteria below to query carrier database and enrich matched CRM contacts with real-time telco intelligence.
                        </div>
                    </div> --}}

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

                    <!-- ============================================================== -->
                    <!-- ACTIVE DEMO FORM: CONTACT DATA ENRICHMENT (IDA PROFILE LOOKUP) -->
                    <!-- Sesuai Requirement: Top App, Age Group, Life Phase, Location,  -->
                    <!-- Lifestyle, Banking & Finance                                   -->
                    <!-- ============================================================== -->
                    <style>
                    .ida-pill-check:checked + .ida-pill-btn {
                        background-color: #fe7d00 !important;
                        border-color: #e06c00 !important;
                        color: #ffffff !important;
                        font-weight: 500;
                        box-shadow: 0 2px 6px rgba(254, 125, 0, 0.25);
                    }
                    .ida-pill-btn {
                        transition: all 0.15s ease-in-out;
                        cursor: pointer;
                        background-color: #ffffff;
                        border: 1px solid #dee2e6;
                        color: #495057;
                    }
                    .ida-pill-btn:hover {
                        border-color: #fe7d00 !important;
                        color: #fe7d00 !important;
                        background-color: #fffaf5;
                    }
                    </style>

                    <div class="card-body">
                        <div class="row g-3">
                            <!-- 1. Top Application -->
                            <div class="col-md-6">
                                <div class="card border shadow-none mb-0 h-100 bg-white">
                                    <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                                        <span class="fs-12 fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="ri-apps-2-line text-warning fs-14"></i>
                                            Top Application
                                        </span>
                                        <span class="fs-11 text-muted">Apps & Digital</span>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                $contactTopApps = [
                                                    'Online Banking' => 'Online Banking',
                                                    'Online Shopping' => 'Online Shopping',
                                                    'Streaming' => 'Streaming',
                                                    'Gaming' => 'Gaming',
                                                    'Social Media' => 'Social Media & Chatting'
                                                ];
                                            @endphp
                                            @foreach($contactTopApps as $appVal => $appLbl)
                                                <input type="checkbox" class="btn-check ida-pill-check" name="top_application[]" value="{{ $appVal }}" id="cDemoApp_{{ Str::slug($appVal) }}" autocomplete="off">
                                                <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoApp_{{ Str::slug($appVal) }}">
                                                    {{ $appLbl }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Age Group -->
                            <div class="col-md-6">
                                <div class="card border shadow-none mb-0 h-100 bg-white">
                                    <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                                        <span class="fs-12 fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="ri-user-star-line text-warning fs-14"></i>
                                            Age Group
                                        </span>
                                        <span class="fs-11 text-muted">Demographics</span>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                $ageGroups = ['< 18 y.o', '18-24 y.o', '25-34 y.o', '35-50 y.o', '> 50 y.o'];
                                            @endphp
                                            @foreach($ageGroups as $aGrp)
                                                <input type="checkbox" class="btn-check ida-pill-check" name="age_group[]" value="{{ $aGrp }}" id="cDemoAge_{{ Str::slug($aGrp) }}" autocomplete="off">
                                                <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoAge_{{ Str::slug($aGrp) }}">
                                                    {{ $aGrp }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Life Phase & Occupation -->
                            <div class="col-md-6">
                                <div class="card border shadow-none mb-0 h-100 bg-white">
                                    <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                                        <span class="fs-12 fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="ri-briefcase-line text-warning fs-14"></i>
                                            Life Phase & Occupation
                                        </span>
                                        <span class="fs-11 text-muted">Career & Life Stage</span>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <input type="checkbox" class="btn-check ida-pill-check" name="life_phase[]" value="School student (>18)" id="cDemoStudent" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoStudent">School student (>18)</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="life_phase[]" value="Higher education" id="cDemoCollege" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoCollege">Higher education</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="life_phase[]" value="Employee" id="cDemoEmployee" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoEmployee">Employee</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Location Based -->
                            <div class="col-md-6">
                                <div class="card border shadow-none mb-0 h-100 bg-white">
                                    <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                                        <span class="fs-12 fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="ri-map-pin-line text-warning fs-14"></i>
                                            Location Based
                                        </span>
                                        <span class="fs-11 text-muted">Tier & Residence</span>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <input type="checkbox" class="btn-check ida-pill-check" name="location_tier[]" value="High" id="cDemoLocHigh" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLocHigh">High Tier</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="location_tier[]" value="Med" id="cDemoLocMed" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLocMed">Med Tier</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="location_tier[]" value="Low" id="cDemoLocLow" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLocLow">Low Tier</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="location_anchor[]" value="Home location" id="cDemoLocHome" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLocHome">Home location</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="location_anchor[]" value="Work location" id="cDemoLocWork" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLocWork">Work location</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="residential_type[]" value="Housing complex" id="cDemoLocComplex" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLocComplex">Housing complex</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="residential_type[]" value="Industrial area" id="cDemoLocIndust" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLocIndust">Industrial area</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Lifestyle -->
                            <div class="col-md-6">
                                <div class="card border shadow-none mb-0 h-100 bg-white">
                                    <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                                        <span class="fs-12 fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="ri-heart-pulse-line text-warning fs-14"></i>
                                            Lifestyle
                                        </span>
                                        <span class="fs-11 text-muted">Habits & Interests</span>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <input type="checkbox" class="btn-check ida-pill-check" name="lifestyle[]" value="Active on social media" id="cDemoLifeSoc" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLifeSoc">Active on social media</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="lifestyle[]" value="Going abroad recently" id="cDemoLifeAbroad" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLifeAbroad">Going abroad recently</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="lifestyle[]" value="Beauty/health enthusiast" id="cDemoLifeBeauty" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLifeBeauty">Beauty/health enthusiast</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="lifestyle[]" value="Foodie" id="cDemoLifeFood" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLifeFood">Foodie</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="lifestyle[]" value="E-commerce users" id="cDemoLifeEcom" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLifeEcom">E-commerce users</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 6. Banking & Finance -->
                            <div class="col-md-6">
                                <div class="card border shadow-none mb-0 h-100 bg-white">
                                    <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                                        <span class="fs-12 fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="ri-bank-card-line text-warning fs-14"></i>
                                            Banking & Finance
                                        </span>
                                        <span class="fs-11 text-muted">Financial Behavior</span>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <input type="checkbox" class="btn-check ida-pill-check" name="banking_behavior[]" value="Personal loan user" id="cDemoLoan" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoLoan">Personal loan user</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="banking_behavior[]" value="Banking user" id="cDemoBnkUser" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoBnkUser">Banking user</label>

                                            <input type="checkbox" class="btn-check ida-pill-check" name="banking_behavior[]" value="Paylater user" id="cDemoPaylater" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="cDemoPaylater">Paylater user</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- LEGACY COMPLETE ACCORDION (SAVED & HIDDEN FOR DEMO PURPOSES)    -->
                    <!-- Div ini tetap tersimpan utuh agar bisa dikembalikan kapan saja  -->
                    <!-- ============================================================== -->
                    <div class="accordion d-flex flex-column gap-3" id="contactEnrichmentFilterAccordion" style="display: none;">
                        
                        <!-- PILLAR 1: CUSTOMER PROFILE DATA -->
                        {{-- rule: aku menambahkan style="display: none;" dengan sengaja untuk kebutuhan DEMO, jangan di buka kecuali aku minta --}}
                        <div class="accordion-item border rounded overflow-hidden shadow-none" style="display: none;">
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
                                                <input type="number" class="form-control form-control-sm" name="age_min" id="cFilterAgeMin" placeholder="18" min="18" max="70">
                                                <span class="text-muted">-</span>
                                                <input type="number" class="form-control form-control-sm" name="age_max" id="cFilterAgeMax" placeholder="70" min="18" max="70">
                                                <span class="fs-12 text-muted">Years</span>
                                            </div>
                                        </div>

                                        <!-- Residential Area / SES -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Residential Area / Class</label>
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

                                        <!-- Life Phase & Occupation -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Life Phase & Occupation</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="life_phase[]" value="School student (>18)" id="cLifeStudent">
                                                    <label class="form-check-label fs-13" for="cLifeStudent">School student (>18)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="life_phase[]" value="Higher education" id="cLifeCollege">
                                                    <label class="form-check-label fs-13" for="cLifeCollege">Higher education (Kuliah)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="life_phase[]" value="Employee" id="cLifeEmployee">
                                                    <label class="form-check-label fs-13" for="cLifeEmployee">Employee (Karyawan)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Search by Area (Sub-City / District) -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Search by Area (Sub-City)</label>
                                            <input type="text" class="form-control form-control-sm" name="search_by_area" id="cFilterArea" placeholder="e.g. Jakarta Selatan, Jakarta Barat, Dago, SCBD, BSD">
                                            <span class="fs-11 text-muted">Spesifik distrik, kecamatan, atau kawasan</span>
                                        </div>

                                        <!-- Job & Workplace -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Job & Workplace</label>
                                            <input type="text" class="form-control form-control-sm" name="job_workplace" id="cFilterJob" placeholder="(e.g. Director, Manager, Tech, Banking, BUMN, ASN, Guru)">
                                            <span class="fs-11 text-muted">Input teks jabatan / industri</span>
                                        </div>

                                        <!-- Social Media Interest -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Social Media Interest</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="TikTok" id="cSocTt">
                                                    <label class="form-check-label fs-13" for="cSocTt">Short Video & Entertainment (TikTok / Reels)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="Instagram" id="cSocIg">
                                                    <label class="form-check-label fs-13" for="cSocIg">Visual & Lifestyle (Instagram)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="LinkedIn" id="cSocLi">
                                                    <label class="form-check-label fs-13" for="cSocLi">Professional & Career (LinkedIn)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="Twitter" id="cSocTw">
                                                    <label class="form-check-label fs-13" for="cSocTw">News & Discussion (X / Twitter)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="WhatsApp" id="cSocWa">
                                                    <label class="form-check-label fs-13" for="cSocWa">Instant Messaging Active (WhatsApp / Telegram)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Region / City (Indonesia Wide & Key Cities) -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center">
                                                <span>Region / City (Seluruh Indonesia & Kota Populer)</span>
                                                <span class="text-muted fs-11 fw-normal">Pilih cakupan pulau atau kota spesifik</span>
                                            </label>
                                            <div class="d-flex flex-wrap gap-2 mt-1 p-2 bg-light rounded border" style="max-height: 140px; overflow-y: auto;">
                                                @php
                                                    $citiesContactList = [
                                                        'Seluruh Indonesia (All)', 'Seluruh Pulau Jawa', 'Jabodetabek',
                                                        'Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Tangerang Selatan', 'Bekasi', 'Banten',
                                                        'Bandung', 'Cirebon', 'Semarang', 'Solo (Surakarta)', 'Yogyakarta',
                                                        'Surabaya', 'Malang', 'Sidoarjo', 'Bali', 'Denpasar',
                                                        'Lombok / NTB', 'NTT (Labuan Bajo & Kupang)', 'Seluruh Sumatera',
                                                        'Medan', 'Batam', 'Pekanbaru', 'Palembang', 'Bandar Lampung',
                                                        'Seluruh Kalimantan', 'Balikpapan', 'Samarinda', 'Kawasan IKN', 'Banjarmasin', 'Pontianak',
                                                        'Seluruh Sulawesi', 'Makassar', 'Manado', 'Maluku & Papua', 'Jayapura'
                                                    ];
                                                @endphp
                                                @foreach($citiesContactList as $ccIdx => $cName)
                                                    <div class="form-check form-check-inline me-2 mb-1">
                                                        <input class="form-check-input" type="checkbox" name="city[]" value="{{ $cName }}" id="cCity_{{ $ccIdx }}">
                                                        <label class="form-check-label fs-12 {{ in_array($cName, ['Seluruh Indonesia (All)', 'Seluruh Pulau Jawa', 'Jabodetabek', 'Seluruh Sumatera', 'Seluruh Kalimantan', 'Seluruh Sulawesi']) ? 'fw-bold text-primary' : '' }}" for="cCity_{{ $ccIdx }}">
                                                            {{ $cName }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 2: BEHAVIOR DATA -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none" style="display: none;">
                            <h2 class="accordion-header" id="cHeadingBehavior">
                                <button class="accordion-button collapsed fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#cCollapseBehavior" aria-expanded="false" aria-controls="cCollapseBehavior">
                                    Behavior Data
                                </button>
                            </h2>
                            <div id="cCollapseBehavior" class="accordion-collapse collapse" data-bs-parent="#contactEnrichmentFilterAccordion" aria-labelledby="cHeadingBehavior">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- SEARCH BY INTEREST (26 KATALOG RESMI IDA) -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center">
                                                <span>Search by Interest (Katalog Resmi IDA - 26 Kategori)</span>
                                                <span class="badge bg-primary-transparent text-primary fs-11">Katalog Resmi IDA</span>
                                            </label>
                                            <div class="d-flex flex-wrap gap-2 p-3 bg-light rounded border">
                                                @php
                                                    $idaContactInterests = [
                                                        'Art & Craft', 'Automotive Enthusiast', 'Beauty Enthusiast', 'Cooking', 'Colleges',
                                                        'Ecommerce Addict', 'Movie Lovers', 'Moslem Fashion', 'Crypto Trader', 'Loves Chatting',
                                                        'Fashion', 'Travel Enthusiast', 'Health Enthusiast', 'Job Seeker', 'Politics',
                                                        'Cashless', 'Ride Hailing Loyalist', 'Active in Social Media', 'Promo Seeker', 'News Reader',
                                                        'Music Addict', 'Photography', 'Food Hunter', 'Gamers', 'Mom & Baby', 'Grocery'
                                                    ];
                                                @endphp
                                                @foreach($idaContactInterests as $cIdx => $cInterest)
                                                    <div class="form-check form-check-inline me-2 mb-2">
                                                        <input class="form-check-input" type="checkbox" name="interest[]" value="{{ $cInterest }}" id="cInterest_{{ $cIdx }}">
                                                        <label class="form-check-label fs-12" for="cInterest_{{ $cIdx }}">
                                                            {{ $cInterest }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Top Application Category -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Top Application Category</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $appContactCategories = [
                                                        'Marketplace & E-Commerce' => 'Marketplace & E-Commerce',
                                                        'Sports & Fitness Tracker' => 'Sports & Fitness Tracker',
                                                        'Mobile Banking & Keuangan' => 'Mobile Banking & Keuangan',
                                                        'E-Wallet & Digital Payment' => 'E-Wallet & Digital Payment',
                                                        'Investasi & Saham' => 'Investasi & Saham',
                                                        'Music & Audio Streaming' => 'Music & Audio Streaming',
                                                        'Video Streaming & VOD' => 'Video Streaming & VOD',
                                                        'Food Delivery & Ojek Online' => 'Food Delivery & Ojek Online',
                                                        'Travel & Tiket Online' => 'Travel & Tiket Online',
                                                        'Mobile Gaming' => 'Mobile Gaming'
                                                    ];
                                                @endphp
                                                @foreach($appContactCategories as $cCatVal => $cCatLabel)
                                                    <div class="form-check me-2 mb-1">
                                                        <input class="form-check-input" type="checkbox" name="top_application[]" value="{{ $cCatVal }}" id="cApp_{{ Str::slug($cCatVal) }}">
                                                        <label class="form-check-label fs-13" for="cApp_{{ Str::slug($cCatVal) }}">{{ $cCatLabel }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

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

                                        <!-- Competitor Product Usage -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Competitor Product Usage</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="Telkomsel" id="cCompTelkomsel">
                                                    <label class="form-check-label fs-13" for="cCompTelkomsel">Telkomsel</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="XL" id="cCompXL">
                                                    <label class="form-check-label fs-13" for="cCompXL">XL Axiata</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="Smartfren" id="cCompSmart">
                                                    <label class="form-check-label fs-13" for="cCompSmart">Smartfren</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competitor_product[]" value="IM3" id="cCompIndosat">
                                                    <label class="form-check-label fs-13" for="cCompIndosat">Indosat / IM3</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Phone & Device Type -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone & Device Brand</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                @php
                                                    $deviceContactBrands = ['Apple iPhone', 'Samsung', 'Xiaomi', 'Oppo', 'Vivo', 'Realme', 'Infinix / Transsion', 'Google Pixel', 'Other Brands'];
                                                @endphp
                                                @foreach($deviceContactBrands as $dBrand)
                                                    <div class="form-check me-2 mb-1">
                                                        <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="{{ $dBrand }}" id="cDev_{{ Str::slug($dBrand) }}">
                                                        <label class="form-check-label fs-13" for="cDev_{{ Str::slug($dBrand) }}">{{ $dBrand }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Banking & Finance Behavior -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Banking & Finance Behavior</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Banking User" id="cBnkUser">
                                                    <label class="form-check-label fs-13" for="cBnkUser">Banking User</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Paylater User" id="cBnkPaylater">
                                                    <label class="form-check-label fs-13" for="cBnkPaylater">Paylater User</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Personal Loan User" id="cBnkLoan">
                                                    <label class="form-check-label fs-13" for="cBnkLoan">Personal Loan User</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Cashless User" id="cBnkCashless">
                                                    <label class="form-check-label fs-13" for="cBnkCashless">Cashless / QRIS User</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preferred Banks / FinTech -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Preferred Banks / FinTech</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BCA" id="cBankBCA">
                                                    <label class="form-check-label fs-13" for="cBankBCA">Bank BCA</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="Mandiri" id="cBankMandiri">
                                                    <label class="form-check-label fs-13" for="cBankMandiri">Bank Mandiri</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BRI" id="cBankBRI">
                                                    <label class="form-check-label fs-13" for="cBankBRI">Bank BRI</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BNI" id="cBankBNI">
                                                    <label class="form-check-label fs-13" for="cBankBNI">Bank BNI</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="CIMB Niaga" id="cBankCIMB">
                                                    <label class="form-check-label fs-13" for="cBankCIMB">Bank CIMB Niaga</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="Digital Banks" id="cBankJago">
                                                    <label class="form-check-label fs-13" for="cBankJago">Bank Digital / Neobank</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Lifestyle Indicator -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Lifestyle Indicator</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="lifestyle[]" value="Going abroad recently" id="cLifeAbroad">
                                                    <label class="form-check-label fs-13" for="cLifeAbroad">Going abroad recently</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Frequently Visited Places (POI) -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Frequently Visited Places (POI)</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="CBD & Office Towers" id="cPlCBD">
                                                    <label class="form-check-label fs-13" for="cPlCBD">Area Perkantoran & SCBD / CBD</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Premium Malls" id="cPlMalls">
                                                    <label class="form-check-label fs-13" for="cPlMalls">Mall & Shopping Center Mewah</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Sports Complex" id="cPlSports">
                                                    <label class="form-check-label fs-13" for="cPlSports">Kawasan Olahraga (GBK & Sport Venues)</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Airports & Transit" id="cPlTransit">
                                                    <label class="form-check-label fs-13" for="cPlTransit">Bandara & Stasiun Kereta Cepat</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Campus Areas" id="cPlCampus">
                                                    <label class="form-check-label fs-13" for="cPlCampus">Kawasan Universitas / Kampus</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 3: ELIGIBILITY CHECK -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none" style="display: none;">
                            <h2 class="accordion-header" id="cHeadingEligibility">
                                <button class="accordion-button collapsed fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#cCollapseEligibility" aria-expanded="false" aria-controls="cCollapseEligibility">
                                    Eligibility Check
                                </button>
                            </h2>
                            <div id="cCollapseEligibility" class="accordion-collapse collapse" data-bs-parent="#contactEnrichmentFilterAccordion" aria-labelledby="cHeadingEligibility">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Risk Exclusions -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Risk Exclusions</label>
                                            <div class="p-3 bg-light rounded border">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="exclude_gambling" value="1" id="cExcludeGambling">
                                                    <label class="form-check-label fs-13 fw-semibold text-dark" for="cExcludeGambling">Exclude Gambling Indicators</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="exclude_blacklist" value="1" id="cExcludeBlacklist">
                                                    <label class="form-check-label fs-13 fw-semibold text-dark" for="cExcludeBlacklist">Exclude Blacklist</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="exclude_negative_credit" value="1" id="cExcludeNegative">
                                                    <label class="form-check-label fs-13 fw-semibold text-dark" for="cExcludeNegative">Exclude Negative Credit / Gagal Bayar</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment History -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Payment History</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="Smooth" id="cPaySmooth">
                                                    <label class="form-check-label fs-13" for="cPaySmooth">Smooth / Lancar</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="On-time" id="cPayOntime">
                                                    <label class="form-check-label fs-13" for="cPayOntime">On-time / Tepat Waktu</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="Late > 30d" id="cPayLate">
                                                    <label class="form-check-label fs-13" for="cPayLate">Late > 30 Days</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Outstanding Limit -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Outstanding Limit</label>
                                            <select class="form-select form-select-sm" name="max_outstanding" id="cFilterOutstanding">
                                                <option value="">No Limit</option>
                                                <option value="5000000">< Rp 5.000.000</option>
                                                <option value="10000000">< Rp 10.000.000</option>
                                                <option value="20000000">< Rp 20.000.000</option>
                                                <option value="99999999">> Rp 20.000.000</option>
                                            </select>
                                        </div>

                                        <!-- Fraud Risk Level -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Fraud Risk Level</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fraud_risk[]" value="Low" id="cRiskLow">
                                                    <label class="form-check-label fs-13" for="cRiskLow">Low Risk</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fraud_risk[]" value="Medium" id="cRiskMed">
                                                    <label class="form-check-label fs-13" for="cRiskMed">Medium Risk</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fraud_risk[]" value="High" id="cRiskHigh">
                                                    <label class="form-check-label fs-13" for="cRiskHigh">High Risk</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Phone Line Status -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone Line Status</label>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="phone_status" value="Active" id="cPhoneActive" checked>
                                                <label class="form-check-label fs-13" for="cPhoneActive">Active Lines Only</label>
                                            </div>
                                        </div>

                                        <!-- Line Tenure / Usia Nomor -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Line Tenure / Usia Nomor</label>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="line_tenure[]" value="> 1 Year" id="cTenure1Yr">
                                                <label class="form-check-label fs-13" for="cTenure1Yr">> 1 Tahun Aktif</label>
                                            </div>
                                        </div>

                                        <!-- Line Subscription -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Line Subscription</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subscription_type[]" value="Postpaid" id="cSubPostpaid">
                                                    <label class="form-check-label fs-13" for="cSubPostpaid">Pascabayar (Postpaid) Saja</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subscription_type[]" value="Prepaid" id="cSubPrepaid">
                                                    <label class="form-check-label fs-13" for="cSubPrepaid">Prabayar (Prepaid)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-top py-2 px-4 justify-content-between flex-shrink-0 bg-white">
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
