<!-- MODAL FILTER FOR DATA ENRICHMENT -->
<div class="modal fade" id="idaCampaignFilterModal" tabindex="-1" aria-labelledby="idaCampaignFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-height: 92vh;">
        <div class="modal-content border-0 shadow d-flex flex-column overflow-hidden" style="max-height: 92vh;">
            <div class="modal-header border-bottom py-3 px-4 flex-shrink-0 bg-white">
                <div>
                    <h6 class="modal-title fw-bold text-dark mb-0" id="idaCampaignFilterModalLabel">Filter Data Enrichment</h6>
                    <!-- Subtitle for modal context -->
                    <span class="fs-12 text-muted">Audience segmentation based on customer profiles, behavior data, and eligibility</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="idaCampaignFilterForm" class="d-flex flex-column flex-grow-1 overflow-hidden m-0 p-0" style="min-height: 0;" onsubmit="return false;">
                <div class="modal-body p-4 overflow-y-auto flex-grow-1" style="max-height: calc(92vh - 130px); padding-bottom: 10px !important;">
                    
                    <!-- ============================================================== -->
                    <!-- ACTIVE DEMO FORM: CAMPAIGN TARGET SEGMENTATION (IDA DISCOVERY) -->
                    <!-- Sesuai Requirement: Gender, Age-Range, Region, Area, Interest -->
                    <!-- ============================================================== -->
                    <!-- ACTIVE DEMO FORM: CAMPAIGN TARGET SEGMENTATION (IDA DISCOVERY) -->
                    <!-- Sesuai Requirement: Gender, Age-Range, Region, Area, Interest, -->
                    <!-- and Income                                                     -->
                    <!-- ============================================================== -->
                    <div class="card custom-card border shadow-none mb-3 bg-white">
                        <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                            <span class="fs-13 fw-bold text-dark d-flex align-items-center gap-2">
                                <i class="ri-user-search-line text-warning fs-15"></i>
                                Campaign Target Audience (Indosat IDA Discovery Flow)
                            </span>
                            <span class="badge bg-warning-transparent text-warning border border-warning border-opacity-25 fs-11">IDA Discovery Spec</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <!-- 1. Search by Gender -->
                                <div class="col-md-6">
                                    <label class="form-label fs-12 fw-semibold text-dark mb-1">Search by Gender</label>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <input type="radio" class="btn-check ida-pill-check" name="gender" value="All" id="fGenderAll" checked autocomplete="off">
                                        <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="fGenderAll">All Gender</label>

                                        <input type="radio" class="btn-check ida-pill-check" name="gender" value="Male" id="fGenderMale" autocomplete="off">
                                        <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="fGenderMale">Male</label>

                                        <input type="radio" class="btn-check ida-pill-check" name="gender" value="Female" id="fGenderFemale" autocomplete="off">
                                        <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="fGenderFemale">Female</label>
                                    </div>
                                </div>

                                <!-- 2. Search by Age Range (18-70 years) -->
                                <div class="col-md-6">
                                    <label class="form-label fs-12 fw-semibold text-dark mb-1">Search by Age-Range</label>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <input type="number" class="form-control form-control-sm text-center" style="max-width: 90px; border-radius: 6px;" name="age_min" id="fFilterAgeMin" value="18" placeholder="18" min="18" max="70">
                                        <span class="text-muted fw-bold">-</span>
                                        <input type="number" class="form-control form-control-sm text-center" style="max-width: 90px; border-radius: 6px;" name="age_max" id="fFilterAgeMax" value="70" placeholder="70" min="18" max="70">
                                        <span class="badge bg-light text-dark border px-2 py-1 fs-12">Years Old</span>
                                    </div>
                                </div>

                            <!-- 3. Search by Region (Based on City) - Custom Select2 Multiple -->
                            <div class="col-12">
                                <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center mb-1">
                                    <span>Search by Region (Based on City)</span>
                                    <span class="text-muted fs-11 fw-normal">Pilih satu atau beberapa Region / Kota cakupan</span>
                                </label>
                                
                                <!-- Hidden select for FormData & Backend submission -->
                                <select name="city[]" id="fFilterRegionSelect" multiple="multiple" style="display: none;"></select>

                                <!-- Rendered Select2 Multiple Box -->
                                <div class="ida-multi-select position-relative" id="idaRegionContainer">
                                    <div class="ida-select-box form-control p-1 d-flex flex-wrap align-items-center bg-white" id="idaRegionBox" style="cursor: text; min-height: 42px; border: 1px solid #ced4da; border-radius: 6px;">
                                        <div class="ida-selected-tags d-flex flex-wrap align-items-center" id="idaRegionTags"></div>
                                        <input type="text" class="ida-input border-0 flex-grow-1 p-1" id="idaRegionInput" placeholder="Ketik untuk mencari Region (e.g: Jakarta, Bogor)..." style="outline: none; font-size: 13px; min-width: 140px; background: transparent;" autocomplete="off">
                                        <button type="button" class="btn btn-sm btn-link text-muted p-0 me-2 ida-clear-btn" id="idaRegionClear" title="Clear all" style="display: none; text-decoration: none; font-size: 18px; line-height: 1; font-weight: bold;">&times;</button>
                                    </div>
                                    <!-- Floating Dropdown Menu -->
                                    <div class="ida-dropdown shadow-lg bg-white border rounded position-absolute start-0 end-0 mt-1 overflow-y-auto" id="idaRegionDropdown" style="display: none; max-height: 250px; z-index: 1060;"></div>
                                </div>
                                <span class="fs-11 text-muted">Bisa memilih lebih dari satu wilayah (misal: Jakarta & Bogor)</span>
                            </div>

                            <!-- 4. Search by Area (Sub-City / District) - Custom Select2 Multiple Dependent -->
                            <div class="col-12">
                                <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center mb-1">
                                    <span>Search by Area</span>
                                    <span class="text-primary fs-11 fw-normal" id="fFilterAreaNotice">Otomatis menyesuaikan dengan Region yang dipilih</span>
                                </label>

                                <!-- Hidden select for FormData & Backend submission -->
                                <select name="search_by_area[]" id="fFilterAreaSelect" multiple="multiple" style="display: none;"></select>

                                <!-- Rendered Select2 Multiple Box -->
                                <div class="ida-multi-select position-relative" id="idaAreaContainer">
                                    <div class="ida-select-box form-control p-1 d-flex flex-wrap align-items-center bg-light" id="idaAreaBox" style="cursor: text; min-height: 42px; border: 1px solid #ced4da; border-radius: 6px;">
                                        <div class="ida-selected-tags d-flex flex-wrap align-items-center" id="idaAreaTags"></div>
                                        <input type="text" class="ida-input border-0 flex-grow-1 p-1" id="idaAreaInput" placeholder="Pilih Region terlebih dahulu..." style="outline: none; font-size: 13px; min-width: 140px; background: transparent;" autocomplete="off" disabled>
                                        <button type="button" class="btn btn-sm btn-link text-muted p-0 me-2 ida-clear-btn" id="idaAreaClear" title="Clear all" style="display: none; text-decoration: none; font-size: 18px; line-height: 1; font-weight: bold;">&times;</button>
                                    </div>
                                    <!-- Floating Dropdown Menu -->
                                    <div class="ida-dropdown shadow-lg bg-white border rounded position-absolute start-0 end-0 mt-1 overflow-y-auto" id="idaAreaDropdown" style="display: none; max-height: 250px; z-index: 1060;">
                                        <div class="p-3 text-center text-muted fs-12">Silakan pilih Region di atas terlebih dahulu.</div>
                                    </div>
                                </div>
                                <span class="fs-11 text-muted">Area/distrik spesifik dari Region yang dipilih (e.g. Jakarta Selatan, PIK, Dago, Sentul)</span>
                            </div>

                            <!-- 5. Search by Interest (Katalog Resmi IDA - 26 Kategori) - Pure Multi-Select -->
                            <div class="col-12">
                                <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center mb-1">
                                    <span>Search by Interest</span>
                                    <span class="badge bg-primary-transparent text-primary fs-11">26 Available Interest Catalogue</span>
                                </label>
                                
                                <!-- Hidden select for FormData & Backend submission -->
                                <select name="interest[]" id="fFilterInterestSelect" multiple="multiple" style="display: none;"></select>

                                <!-- Rendered Select2 Multiple Box -->
                                <div class="ida-multi-select position-relative" id="idaInterestContainer">
                                    <div class="ida-select-box form-control p-1 d-flex flex-wrap align-items-center bg-white" id="idaInterestBox" style="cursor: text; min-height: 42px; border: 1px solid #ced4da; border-radius: 6px;">
                                        <div class="ida-selected-tags d-flex flex-wrap align-items-center" id="idaInterestTags"></div>
                                        <input type="text" class="ida-input border-0 flex-grow-1 p-1" id="idaInterestInput" placeholder="Ketik atau pilih minat (e.g: Crypto, Automotive, Fashion)..." style="outline: none; font-size: 13px; min-width: 140px; background: transparent;" autocomplete="off">
                                        <button type="button" class="btn btn-sm btn-link text-muted p-0 me-2 ida-clear-btn" id="idaInterestClear" title="Clear all" style="display: none; text-decoration: none; font-size: 18px; line-height: 1; font-weight: bold;">&times;</button>
                                    </div>
                                    <!-- Floating Dropdown Menu -->
                                    <div class="ida-dropdown shadow-lg bg-white border rounded position-absolute start-0 end-0 mt-1 overflow-y-auto" id="idaInterestDropdown" style="display: none; max-height: 250px; z-index: 1060;"></div>
                                </div>
                                <span class="fs-11 text-muted">Pilih satu atau beberapa kategori minat dari 26 katalog resmi IDA</span>
                            </div>

                                <!-- 6. Search by Income (Pill Checkboxes) -->
                                <div class="col-12 mt-2">
                                    <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center mb-1">
                                        <span>Search by Income</span>
                                        <span class="text-muted fs-11 fw-normal">Pilih satu atau lebih rentang pendapatan bulanan</span>
                                    </label>
                                    <div class="d-flex flex-wrap gap-2 p-2 bg-light rounded border align-items-center">
                                        @php
                                            $incomeRanges = ['< 1 Juta', '1-10 Juta', '10-100 Juta', '100 Juta-1 M'];
                                        @endphp
                                        @foreach($incomeRanges as $inIdx => $incomeLabel)
                                            <input type="checkbox" class="btn-check ida-pill-check" name="income[]" value="{{ $incomeLabel }}" id="fIncome_{{ $inIdx }}" autocomplete="off">
                                            <label class="btn btn-sm rounded-pill px-3 py-1 fs-12 ida-pill-btn" for="fIncome_{{ $inIdx }}">
                                                {{ $incomeLabel }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <span class="fs-11 text-muted">Estimasi kemampuan finansial dan pendapatan pelanggan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- LEGACY COMPLETE ACCORDION (SAVED & HIDDEN FOR DEMO PURPOSES)    -->
                    <!-- Div ini tetap tersimpan utuh agar bisa dikembalikan kapan saja  -->
                    <!-- ============================================================== -->
                    <div class="accordion d-flex flex-column gap-3" id="enrichmentFilterAccordion" style="display: none;">
                        
                        <!-- PILLAR 1: CUSTOMER PROFILE DATA -->
                        {{-- rule: aku menambahkan style="display: none;" dengan sengaja untuk kebutuhan DEMO, jangan di buka kecuali aku minta --}}
                        <div class="accordion-item border rounded overflow-hidden shadow-none" style="display: none;">
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
                                                <input type="number" class="form-control form-control-sm" name="age_min" id="fFilterAgeMin" placeholder="18" min="18" max="70">
                                                <span class="text-muted">-</span>
                                                <input type="number" class="form-control form-control-sm" name="age_max" id="fFilterAgeMax" placeholder="70" min="18" max="70">
                                                <span class="fs-12 text-muted">Years</span>
                                            </div>
                                        </div>

                                        <!-- Residential Area / SES -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Residential Area / Class</label>
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

                                        <!-- Life Phase & Occupation -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Life Phase & Occupation</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="life_phase[]" value="School student (>18)" id="fLifeStudent">
                                                    <label class="form-check-label fs-13" for="fLifeStudent">School student (>18)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="life_phase[]" value="Higher education" id="fLifeCollege">
                                                    <label class="form-check-label fs-13" for="fLifeCollege">Higher education (Kuliah)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="life_phase[]" value="Employee" id="fLifeEmployee">
                                                    <label class="form-check-label fs-13" for="fLifeEmployee">Employee (Karyawan)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Search by Area (Sub-City / District) -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Search by Area (Sub-City)</label>
                                            <input type="text" class="form-control form-control-sm" name="legacy_search_by_area" id="fFilterArea" placeholder="e.g. Jakarta Selatan, Jakarta Barat, Dago, SCBD, BSD">
                                            <span class="fs-11 text-muted">Spesifik distrik, kecamatan, atau kawasan</span>
                                        </div>

                                        <!-- Daerah / Kota (Indonesia Wide & Key Cities) -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center">
                                                <span>Region / City (Seluruh Indonesia & Kota Populer)</span>
                                                <span class="text-muted fs-11 fw-normal">Pilih cakupan pulau atau kota spesifik</span>
                                            </label>
                                            <div class="d-flex flex-wrap gap-2 mt-1 p-2 bg-light rounded border" style="max-height: 140px; overflow-y: auto;">
                                                @php
                                                    $citiesList = [
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
                                                @foreach($citiesList as $cIdx => $cityName)
                                                    <div class="form-check form-check-inline me-2 mb-1">
                                                        <input class="form-check-input" type="checkbox" name="city[]" value="{{ $cityName }}" id="fCity_{{ $cIdx }}">
                                                        <label class="form-check-label fs-12 {{ in_array($cityName, ['Seluruh Indonesia (All)', 'Seluruh Pulau Jawa', 'Jabodetabek', 'Seluruh Sumatera', 'Seluruh Kalimantan', 'Seluruh Sulawesi']) ? 'fw-bold text-primary' : '' }}" for="fCity_{{ $cIdx }}">
                                                            {{ $cityName }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Job & Workplace -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Job & Workplace</label>
                                            <input type="text" class="form-control form-control-sm" name="job_workplace" id="fFilterJob" placeholder="(e.g. Director, Manager, Tech, Banking, BUMN, ASN, Guru)">
                                            <span class="fs-11 text-muted">Input teks jabatan / industri</span>
                                        </div>

                                        <!-- Social Media Interest -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Social Media Interest</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="TikTok" id="fSocTt">
                                                    <label class="form-check-label fs-13" for="fSocTt">Short Video & Entertainment (TikTok / Reels)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="Instagram" id="fSocIg">
                                                    <label class="form-check-label fs-13" for="fSocIg">Visual & Lifestyle (Instagram)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="LinkedIn" id="fSocLi">
                                                    <label class="form-check-label fs-13" for="fSocLi">Professional & Career (LinkedIn)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="Twitter" id="fSocTw">
                                                    <label class="form-check-label fs-13" for="fSocTw">News & Discussion (X / Twitter)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="social_media[]" value="WhatsApp" id="fSocWa">
                                                    <label class="form-check-label fs-13" for="fSocWa">Instant Messaging Active (WhatsApp / Telegram)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 2: BEHAVIOR DATA -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none" style="display: none;">
                            <h2 class="accordion-header" id="headingBehavior">
                                <button class="accordion-button collapsed fw-bold text-dark py-3 px-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBehavior" aria-expanded="false" aria-controls="collapseBehavior">
                                    Behavior Data
                                </button>
                            </h2>
                            <div id="collapseBehavior" class="accordion-collapse collapse" data-bs-parent="#enrichmentFilterAccordion" aria-labelledby="headingBehavior">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        <!-- Top Application Category -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Top Application Category</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $appCategories = [
                                                        'Online Banking' => 'Online Banking',
                                                        'Online Shopping' => 'Online Shopping / Marketplace',
                                                        'Streaming' => 'Streaming (Audio & Video)',
                                                        'Gaming' => 'Gaming',
                                                        'Social Media' => 'Social Media & Chatting',
                                                        'E-Wallet' => 'E-Wallet & Digital Payment',
                                                        'Investasi' => 'Investasi & Saham',
                                                        'Food Delivery' => 'Food Delivery & Ojek Online',
                                                        'Travel Booking' => 'Travel & Tiket Online',
                                                        'Fitness & Sports' => 'Sports & Fitness Tracker'
                                                    ];
                                                @endphp
                                                @foreach($appCategories as $catVal => $catLabel)
                                                    <div class="form-check me-2 mb-1">
                                                        <input class="form-check-input" type="checkbox" name="top_application[]" value="{{ $catVal }}" id="fApp_{{ Str::slug($catVal) }}">
                                                        <label class="form-check-label fs-13" for="fApp_{{ Str::slug($catVal) }}">{{ $catLabel }}</label>
                                                    </div>
                                                @endforeach
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

                                        <!-- Phone & Device Type -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone & Device Brand</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $deviceBrands = ['Apple iPhone', 'Samsung Galaxy', 'Xiaomi', 'Oppo', 'Vivo', 'Realme', 'Infinix / Transsion', 'Google Pixel', 'Other Brands'];
                                                @endphp
                                                @foreach($deviceBrands as $brand)
                                                    <div class="form-check me-2 mb-1">
                                                        <input class="form-check-input" type="checkbox" name="phone_device_type[]" value="{{ $brand }}" id="fDev_{{ Str::slug($brand) }}">
                                                        <label class="form-check-label fs-13" for="fDev_{{ Str::slug($brand) }}">{{ $brand }}</label>
                                                    </div>
                                                @endforeach
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

                                        <!-- Banking & Finance Behavior -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Banking & Finance Behavior</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Banking User" id="fBnkUser">
                                                    <label class="form-check-label fs-13" for="fBnkUser">Banking User</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Paylater User" id="fBnkPaylater">
                                                    <label class="form-check-label fs-13" for="fBnkPaylater">Paylater User</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Personal Loan User" id="fBnkLoan">
                                                    <label class="form-check-label fs-13" for="fBnkLoan">Personal Loan User</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="banking_behavior[]" value="Cashless User" id="fBnkCashless">
                                                    <label class="form-check-label fs-13" for="fBnkCashless">Cashless / QRIS User</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Lifestyle Indicator -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Lifestyle Indicator</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="lifestyle[]" value="Going abroad recently" id="fLifeAbroad">
                                                    <label class="form-check-label fs-13" for="fLifeAbroad">Going abroad recently</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="lifestyle[]" value="Active on Social Media" id="fLifeSocmed">
                                                    <label class="form-check-label fs-13" for="fLifeSocmed">Active on Social Media</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="lifestyle[]" value="Foodie" id="fLifeFoodie">
                                                    <label class="form-check-label fs-13" for="fLifeFoodie">Foodie / Culinary</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preferred Banks / FinTech -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Preferred Banks / FinTech</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BCA" id="fBankBCA">
                                                    <label class="form-check-label fs-13" for="fBankBCA">Bank BCA</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="Mandiri" id="fBankMandiri">
                                                    <label class="form-check-label fs-13" for="fBankMandiri">Bank Mandiri</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BRI" id="fBankBRI">
                                                    <label class="form-check-label fs-13" for="fBankBRI">Bank BRI</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="BNI" id="fBankBNI">
                                                    <label class="form-check-label fs-13" for="fBankBNI">Bank BNI</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="CIMB Niaga" id="fBankCIMB">
                                                    <label class="form-check-label fs-13" for="fBankCIMB">Bank CIMB Niaga</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="preferred_banks[]" value="Digital Banks" id="fBankJago">
                                                    <label class="form-check-label fs-13" for="fBankJago">Bank Digital / Neobank</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Frequently Visited Places -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Frequently Visited Places (POI Category)</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="CBD & Office Towers" id="fPlCBD">
                                                    <label class="form-check-label fs-13" for="fPlCBD">Area Perkantoran & SCBD / CBD</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Premium Malls" id="fPlMalls">
                                                    <label class="form-check-label fs-13" for="fPlMalls">Mall & Shopping Center Mewah</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Sports Complex" id="fPlSports">
                                                    <label class="form-check-label fs-13" for="fPlSports">Kawasan Olahraga (GBK & Sport Venues)</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Airports & Transit" id="fPlTransit">
                                                    <label class="form-check-label fs-13" for="fPlTransit">Bandara & Stasiun Kereta Cepat</label>
                                                </div>
                                                <div class="form-check me-2 mb-1">
                                                    <input class="form-check-input" type="checkbox" name="frequently_visited_places[]" value="Campus Areas" id="fPlCampus">
                                                    <label class="form-check-label fs-13" for="fPlCampus">Kawasan Universitas / Kampus</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SEARCH BY INTEREST (26 KATALOG RESMI IDA) -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark d-flex justify-content-between align-items-center">
                                                <span>Search by Interest (Katalog Resmi IDA - 26 Kategori)</span>
                                                <span class="badge bg-primary-transparent text-primary fs-11">IDA Standard Catalogue</span>
                                            </label>
                                            <div class="d-flex flex-wrap gap-2 p-3 bg-light rounded border">
                                                @php
                                                    $idaInterests = [
                                                        'Art & Craft', 'Automotive Enthusiast', 'Beauty Enthusiast', 'Cooking', 'Colleges',
                                                        'Ecommerce Addict', 'Movie Lovers', 'Moslem Fashion', 'Crypto Trader', 'Loves Chatting',
                                                        'Fashion', 'Travel Enthusiast', 'Health Enthusiast', 'Job Seeker', 'Politics',
                                                        'Cashless', 'Ride Hailing Loyalist', 'Active in Social Media', 'Promo Seeker', 'News Reader',
                                                        'Music Addict', 'Photography', 'Food Hunter', 'Gamers', 'Mom & Baby', 'Grocery'
                                                    ];
                                                @endphp
                                                @foreach($idaInterests as $idx => $interestItem)
                                                    <div class="form-check form-check-inline me-2 mb-2">
                                                        <input class="form-check-input" type="checkbox" name="interest[]" value="{{ $interestItem }}" id="fInterest_{{ $idx }}">
                                                        <label class="form-check-label fs-12" for="fInterest_{{ $idx }}">
                                                            {{ $interestItem }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PILLAR 3: ELIGIBILITY CHECK -->
                        <div class="accordion-item border rounded overflow-hidden shadow-none" style="display: none;">
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
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="exclude_blacklist" value="1" id="fExcludeBlacklist">
                                                    <label class="form-check-label fs-13 fw-semibold text-dark" for="fExcludeBlacklist">
                                                        Exclude Blacklist
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="exclude_negative_credit" value="1" id="fExcludeNegative">
                                                    <label class="form-check-label fs-13 fw-semibold text-dark" for="fExcludeNegative">
                                                        Exclude Negative Credit / Gagal Bayar
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment History -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Payment History</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="Smooth" id="fPaySmooth">
                                                    <label class="form-check-label fs-13" for="fPaySmooth">Smooth / Lancar</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_history[]" value="On-time" id="fPayOntime">
                                                    <label class="form-check-label fs-13" for="fPayOntime">On-time / Tepat Waktu</label>
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
                                                <option value="5000000">< Rp 5.000.000</option>
                                                <option value="10000000">< Rp 10.000.000</option>
                                                <option value="20000000">< Rp 20.000.000</option>
                                                <option value="99999999">> Rp 20.000.000</option>
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

                                        <!-- Phone Line Status -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Phone Line Status</label>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="phone_status" value="Active" id="fPhoneActive" checked>
                                                <label class="form-check-label fs-13" for="fPhoneActive">Active Lines Only</label>
                                            </div>
                                        </div>

                                        <!-- Line Tenure / Usia Nomor -->
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold text-dark">Line Tenure / Usia Nomor</label>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="line_tenure[]" value="> 1 Year" id="fTenure1Yr">
                                                <label class="form-check-label fs-13" for="fTenure1Yr">> 1 Tahun Aktif</label>
                                            </div>
                                        </div>

                                        <!-- Line Subscription -->
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold text-dark">Line Subscription</label>
                                            <div class="d-flex flex-wrap gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subscription_type[]" value="Postpaid" id="fSubPostpaid">
                                                    <label class="form-check-label fs-13" for="fSubPostpaid">Pascabayar (Postpaid) Saja</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subscription_type[]" value="Prepaid" id="fSubPrepaid">
                                                    <label class="form-check-label fs-13" for="fSubPrepaid">Prabayar (Prepaid)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light py-2 px-4 flex-shrink-0 border-top">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-4" id="cBtnSubmitFilter">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- ZERO-DEPENDENCY SELECT2 MULTI-SELECT COMPONENT (REGION & AREA) -->
<!-- ============================================================== -->
<style>
/* Selectable Pill Buttons (Sunny Theme #fe7d00) */
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

/* Custom Multi-Select Select2 styling matching Sunny theme (Sunny Orange #fe7d00) */
.ida-select-box {
    background-color: #ffffff;
    border: 1px solid #ced4da;
    border-radius: 6px;
    min-height: 42px;
    padding: 3px 6px;
    cursor: text;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.ida-select-box.focused {
    border-color: #fe7d00 !important;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(254, 125, 0, 0.18) !important;
}
.ida-tag-pill {
    background-color: #fe7d00 !important;
    border: 1px solid #e06c00 !important;
    color: #ffffff !important;
    border-radius: 4px;
    padding: 3px 8px 3px 6px !important;
    font-size: 12.5px;
    font-weight: 500;
    margin: 2px 4px 2px 2px;
    display: inline-flex;
    align-items: center;
    line-height: 1.3;
}
.ida-tag-remove {
    color: #ffffff !important;
    margin-right: 5px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    line-height: 1;
    display: inline-block;
    padding: 0;
}
.ida-tag-remove:hover {
    color: #ffe6cc !important;
}
.ida-tag-text {
    color: #ffffff;
    padding: 0;
}
.ida-clear-btn {
    color: #888888;
    font-size: 18px;
    cursor: pointer;
    line-height: 1;
    padding: 0 4px;
}
.ida-clear-btn:hover {
    color: #fe7d00 !important;
}
.ida-dropdown {
    border: 1px solid #ced4da;
    border-radius: 6px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    background-color: #ffffff;
}
.ida-optgroup-header {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 6px 12px;
    border-bottom: 1px solid #e9ecef;
}
.ida-option-item {
    padding: 8px 14px;
    font-size: 13px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #212529;
    transition: background-color 0.15s;
}
.ida-option-item:hover {
    background-color: #fff4ea;
    color: #fe7d00;
}
.ida-option-item.selected {
    background-color: #fff8f2;
    color: #fe7d00;
    font-weight: 600;
}
</style>

<script>
(function() {
    // 1. Database Kategori & Kota Region
    const IDA_REGION_CATEGORIES = {
        'Cakupan Makro / Wilayah': [
            'Jabodetabek', 'Seluruh Pulau Jawa', 'Seluruh Sumatera', 
            'Seluruh Kalimantan', 'Seluruh Sulawesi', 'Seluruh Indonesia (All)'
        ],
        'Jabodetabek & Banten': [
            'Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Tangerang Selatan', 'Bekasi'
        ],
        'Jawa Barat & Jawa Tengah': [
            'Bandung', 'Cirebon', 'Semarang', 'Solo (Surakarta)', 'Yogyakarta'
        ],
        'Jawa Timur & Bali Nusra': [
            'Surabaya', 'Malang', 'Sidoarjo', 'Bali', 'Denpasar', 'Lombok / NTB', 'NTT (Labuan Bajo & Kupang)'
        ],
        'Sumatera': [
            'Medan', 'Batam', 'Pekanbaru', 'Palembang', 'Bandar Lampung'
        ],
        'Kalimantan & IKN Nusantara': [
            'Balikpapan', 'Samarinda', 'Kawasan IKN', 'Banjarmasin', 'Pontianak'
        ],
        'Sulawesi, Maluku & Papua': [
            'Makassar', 'Manado', 'Maluku & Papua', 'Jayapura'
        ]
    };

    // 2. Database Pemetaan Region -> Sub-City Area
    const IDA_REGION_AREA_MAP = {
        'Jakarta': [
            'Jakarta Pusat (Monas, Thamrin, Sudirman)',
            'Jakarta Selatan (SCBD, Senopati, Kebayoran)',
            'Jakarta Selatan (Kemang, Cilandak, Blok M)',
            'Jakarta Selatan (Tebet, Pasar Minggu)',
            'Jakarta Barat (Puri Indah, Kebon Jeruk)',
            'Jakarta Barat (Tomang, Grogol, Tanjung Duren)',
            'Jakarta Utara (Pantai Indah Kapuk / PIK)',
            'Jakarta Utara (Kelapa Gading, Sunter)',
            'Jakarta Utara (Pluit, Ancol)',
            'Jakarta Timur (Rawamangun, Jatinegara)',
            'Jakarta Timur (Cibubur, Duren Sawit, Cakung)'
        ],
        'Bogor': [
            'Sentul City & Babakan Madang',
            'Bogor Timur (Baranangsiang, Pajajaran)',
            'Bogor Tengah (Kebun Raya, Juanda)',
            'Bogor Selatan (Batutulis)',
            'Bogor Barat & Yasmin',
            'Cibinong & Pemda Bogor',
            'Ciawi & Kawasan Puncak'
        ],
        'Depok': [
            'Margonda Raya',
            'Cinere & Gandul',
            'Sawangan & Bojongsari',
            'Cimanggis & Cibubur Junction',
            'Beji & Kampus UI Depok',
            'Pancoran Mas'
        ],
        'Tangerang': [
            'Tangerang Kota & Modernland',
            'Karawaci & Lippo Village',
            'Cikokol & Cipondoh',
            'Bandara Soekarno-Hatta (Soetta)',
            'Balaraja & Cikupa'
        ],
        'Tangerang Selatan': [
            'BSD City (Bumi Serpong Damai)',
            'Bintaro Jaya (Sektor 1 - 9)',
            'Alam Sutera & Flavor Bliss',
            'Gading Serpong & Scientia',
            'Pamulang & Ciputat'
        ],
        'Bekasi': [
            'Bekasi Barat (Summarecon Bekasi)',
            'Bekasi Selatan (Grand Galaxy, Pekayon)',
            'Bekasi Timur',
            'Cikarang Pusat (Lippo Cikarang)',
            'Cikarang Selatan (Jababeka & EJIP)',
            'Tambun & Cibitung'
        ],
        'Bandung': [
            'Dago (Ir. H. Djuanda)',
            'Buah Batu & Telkom University',
            'Setiabudi & Kawasan Lembang',
            'Sukajadi & Paris Van Java (PVJ)',
            'Riau (LLRE Martadinata)',
            'Cihampelas & Pasteur',
            'Gedebage & Summarecon Bandung',
            'Cimahi Kota'
        ],
        'Cirebon': [
            'Cirebon Kejaksan',
            'Cirebon Lemahwungkuk',
            'Kesambi & Harjamukti'
        ],
        'Semarang': [
            'Simpang Lima & Gajahmada',
            'Candisari (Semarang Atas / Gombel)',
            'Tembalang & Undip',
            'Banyumanik',
            'Kota Lama & Johar'
        ],
        'Solo (Surakarta)': [
            'Slamet Riyadi & Pusat Kota',
            'Solo Baru',
            'Banjarsari & Manahan',
            'Laweyan (Kampung Batik)',
            'Jebres & UNS'
        ],
        'Yogyakarta': [
            'Malioboro & Kraton',
            'Sleman (Seturan, Babarsari)',
            'Kaliurang & Jakal',
            'UGM, Sagan, Gejayan',
            'Kotagede & Bantul'
        ],
        'Surabaya': [
            'Surabaya Barat (Pakuwon Mall, CitraLand)',
            'Surabaya Pusat (Tunjungan Plaza, Basuki Rahmat)',
            'Surabaya Timur (Rungkut, Kertajaya, Galaxy Mall)',
            'Surabaya Selatan (Darmo, Wonokromo)',
            'Surabaya Utara (Perak, Kenjeran)'
        ],
        'Sidoarjo': [
            'Sidoarjo Kota & Alun-alun',
            'Waru & Aloha'
        ],
        'Malang': [
            'Ijen Boulevard & Klojen',
            'Lowokwaru & Soekarno Hatta (Suhat)',
            'Kota Wisata Batu',
            'Blimbing'
        ],
        'Bali': [
            'Denpasar Kota (Renon & Sanur)',
            'Kuta, Legian, Seminyak',
            'Canggu & Berawa',
            'Jimbaran & Uluwatu',
            'Nusa Dua (BTDC)',
            'Ubud & Gianyar'
        ],
        'Denpasar': [
            'Denpasar Kota (Renon & Sanur)',
            'Kuta, Legian, Seminyak',
            'Canggu & Berawa'
        ],
        'Lombok / NTB': [
            'Mataram Kota',
            'Senggigi Beach',
            'Mandalika & Kuta Lombok'
        ],
        'NTT (Labuan Bajo & Kupang)': [
            'Labuan Bajo (Kawasan Wisata)',
            'Kupang Kota'
        ],
        'Medan': [
            'Medan Barat (Kesawan)',
            'Medan Baru & Polonia',
            'Medan Petisah',
            'Medan Sunggal (Ring Road)',
            'Letda Sujono & Tembung'
        ],
        'Batam': [
            'Batam Center',
            'Nagoya & Jodoh',
            'Sekupang & Marina',
            'Nongsa'
        ],
        'Pekanbaru': [
            'Sukajadi & Sudirman',
            'Tampan (Panam)',
            'Marpoyan Damai',
            'Rumbai'
        ],
        'Palembang': [
            'Ilir Barat (Palembang Icon, PSCC)',
            'Ilir Timur & Sudirman',
            'Seberang Ulu (Jakabaring)'
        ],
        'Bandar Lampung': [
            'Tanjung Karang',
            'Teluk Betung',
            'Way Halim'
        ],
        'Makassar': [
            'Panakkukang',
            'Ujung Pandang (Pantai Losari)',
            'Tamalanrea (Unhas)',
            'Mariso & Tanjung Bunga (CPI)'
        ],
        'Manado': [
            'Boulevard (Piere Tendean)',
            'Malalayang',
            'Wenang'
        ],
        'Balikpapan': [
            'Balikpapan Kota (Sudirman)',
            'Balikpapan Baru',
            'Balikpapan Selatan'
        ],
        'Samarinda': [
            'Samarinda Kota',
            'Samarinda Ulu',
            'Sungai Kunjang'
        ],
        'Kawasan IKN': [
            'KIPP IKN (Kawasan Inti)',
            'Sepaku'
        ],
        'Banjarmasin': [
            'Banjarmasin Tengah',
            'Banjarmasin Selatan'
        ],
        'Pontianak': [
            'Pontianak Kota',
            'Pontianak Selatan (Untan)'
        ],
        'Maluku & Papua': [
            'Jayapura Kota & Abepura',
            'Ambon Kota'
        ],
        'Jayapura': [
            'Jayapura Kota & Abepura'
        ]
    };

    // 3. Makro Wilayah (Unpack ke kota-kota pembentuknya)
    const MACRO_REGION_MAP = {
        'Jabodetabek': ['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Tangerang Selatan', 'Bekasi'],
        'Seluruh Pulau Jawa': ['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Tangerang Selatan', 'Bekasi', 'Bandung', 'Cirebon', 'Semarang', 'Solo (Surakarta)', 'Yogyakarta', 'Surabaya', 'Malang', 'Sidoarjo'],
        'Seluruh Sumatera': ['Medan', 'Batam', 'Pekanbaru', 'Palembang', 'Bandar Lampung'],
        'Seluruh Kalimantan': ['Balikpapan', 'Samarinda', 'Kawasan IKN', 'Banjarmasin', 'Pontianak'],
        'Seluruh Sulawesi': ['Makassar', 'Manado'],
        'Seluruh Indonesia (All)': ['Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Medan', 'Makassar', 'Bali', 'Balikpapan']
    };

    // 4. Katalog Resmi 26 Kategori Minat (Interest) IDA
    const IDA_INTEREST_CATEGORIES = {
        'Lifestyle & Hobbies': [
            'Art & Craft', 'Cooking', 'Photography', 'Travel Enthusiast', 'Movie Lovers', 'Music Addict', 'Gamers'
        ],
        'Digital, Tech & Finance': [
            'Crypto Trader', 'Ecommerce Addict', 'Cashless', 'Active in Social Media', 'Loves Chatting', 'Ride Hailing Loyalist'
        ],
        'Fashion & Personal Care': [
            'Beauty Enthusiast', 'Fashion', 'Moslem Fashion'
        ],
        'Shopping & Daily Needs': [
            'Food Hunter', 'Grocery', 'Promo Seeker', 'Mom & Baby'
        ],
        'Career, Society & Automotive': [
            'Automotive Enthusiast', 'Job Seeker', 'Colleges', 'Health Enthusiast', 'Politics', 'News Reader'
        ]
    };

    // State Tracking
    const selectedRegions = new Set();
    const selectedAreas = new Set();
    const selectedInterests = new Set();

    // DOM Elements
    const regionBox = document.getElementById('idaRegionBox');
    const regionTags = document.getElementById('idaRegionTags');
    const regionInput = document.getElementById('idaRegionInput');
    const regionClear = document.getElementById('idaRegionClear');
    const regionDropdown = document.getElementById('idaRegionDropdown');
    const hiddenRegionSelect = document.getElementById('fFilterRegionSelect');

    const areaBox = document.getElementById('idaAreaBox');
    const areaTags = document.getElementById('idaAreaTags');
    const areaInput = document.getElementById('idaAreaInput');
    const areaClear = document.getElementById('idaAreaClear');
    const areaDropdown = document.getElementById('idaAreaDropdown');
    const hiddenAreaSelect = document.getElementById('fFilterAreaSelect');
    const areaNotice = document.getElementById('fFilterAreaNotice');

    const interestBox = document.getElementById('idaInterestBox');
    const interestTags = document.getElementById('idaInterestTags');
    const interestInput = document.getElementById('idaInterestInput');
    const interestClear = document.getElementById('idaInterestClear');
    const interestDropdown = document.getElementById('idaInterestDropdown');
    const hiddenInterestSelect = document.getElementById('fFilterInterestSelect');

    if (!regionBox || !areaBox) return;

    // Disable inputs in hidden legacy accordion to prevent FormData collision
    const legacyAccordion = document.getElementById('idaCampaignFilterAccordion');
    if (legacyAccordion) {
        legacyAccordion.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);
    }

    // Helper: Buat Badge / Pill Tag Merah dengan tanda silang 'x'
    function createTagPill(label, value, onRemove) {
        const pill = document.createElement('span');
        pill.className = 'ida-tag-pill';
        pill.dataset.value = value;

        const removeBtn = document.createElement('span');
        removeBtn.className = 'ida-tag-remove';
        removeBtn.innerHTML = '&times;';
        removeBtn.title = 'Hapus pilihan';
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            onRemove(value);
        });

        const textSpan = document.createElement('span');
        textSpan.className = 'ida-tag-text';
        textSpan.textContent = label;

        pill.appendChild(removeBtn);
        pill.appendChild(textSpan);
        return pill;
    }

    // Render Tag & Hidden Select untuk REGION
    function renderRegionTags() {
        regionTags.innerHTML = '';
        hiddenRegionSelect.innerHTML = '';

        selectedRegions.forEach(val => {
            // Tambahkan pill merah
            const pill = createTagPill(val, val, function(v) {
                selectedRegions.delete(v);
                renderRegionTags();
                updateAreaOptions();
                filterRegionDropdown(regionInput.value);
            });
            regionTags.appendChild(pill);

            // Tambahkan hidden option agar FormData menangkap nilainya
            const opt = document.createElement('option');
            opt.value = val;
            opt.selected = true;
            hiddenRegionSelect.appendChild(opt);
        });

        if (selectedRegions.size > 0) {
            regionClear.style.display = 'block';
            regionInput.placeholder = 'Ketik untuk menambah Region...';
        } else {
            regionClear.style.display = 'none';
            regionInput.placeholder = 'Ketik untuk mencari Region (e.g: Jakarta, Bogor)...';
        }
    }

    // Render Dropdown untuk REGION
    function populateRegionDropdown() {
        regionDropdown.innerHTML = '';
        for (const [groupLabel, cities] of Object.entries(IDA_REGION_CATEGORIES)) {
            const groupHeader = document.createElement('div');
            groupHeader.className = 'ida-optgroup-header';
            groupHeader.textContent = groupLabel;
            regionDropdown.appendChild(groupHeader);

            cities.forEach(city => {
                const optItem = document.createElement('div');
                optItem.className = 'ida-option-item';
                optItem.dataset.value = city;
                optItem.dataset.label = city.toLowerCase();

                const isSelected = selectedRegions.has(city);
                if (isSelected) optItem.classList.add('selected');

                optItem.innerHTML = `
                    <span>${city}</span>
                    ${isSelected ? '<i class="ri-check-line fw-bold fs-14" style="color: #fe7d00;"></i>' : ''}
                `;

                optItem.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (selectedRegions.has(city)) {
                        selectedRegions.delete(city);
                    } else {
                        selectedRegions.add(city);
                    }
                    regionInput.value = '';
                    renderRegionTags();
                    populateRegionDropdown();
                    updateAreaOptions();
                    regionInput.focus();
                });

                regionDropdown.appendChild(optItem);
            });
        }
    }

    // Filter pencarian REGION
    function filterRegionDropdown(query) {
        const q = (query || '').toLowerCase().trim();
        let matchCount = 0;

        const headers = regionDropdown.querySelectorAll('.ida-optgroup-header');
        headers.forEach(header => {
            let nextEl = header.nextElementSibling;
            let groupHasMatch = false;

            while (nextEl && nextEl.classList.contains('ida-option-item')) {
                const text = nextEl.dataset.label || '';
                if (!q || text.includes(q)) {
                    nextEl.style.display = 'flex';
                    groupHasMatch = true;
                    matchCount++;
                } else {
                    nextEl.style.display = 'none';
                }
                nextEl = nextEl.nextElementSibling;
            }

            header.style.display = groupHasMatch ? 'block' : 'none';
        });

        // Hapus no result message lama jika ada
        const existingNoRes = regionDropdown.querySelector('.ida-no-results');
        if (existingNoRes) existingNoRes.remove();

        if (matchCount === 0) {
            const noRes = document.createElement('div');
            noRes.className = 'ida-no-results p-3 text-center text-muted fs-12';
            noRes.textContent = `Tidak ada Region yang cocok dengan "${query}"`;
            regionDropdown.appendChild(noRes);
        }
    }

    // Render Tag & Hidden Select untuk AREA
    function renderAreaTags() {
        areaTags.innerHTML = '';
        hiddenAreaSelect.innerHTML = '';

        selectedAreas.forEach(val => {
            const pill = createTagPill(val, val, function(v) {
                selectedAreas.delete(v);
                renderAreaTags();
                filterAreaDropdown(areaInput.value);
            });
            areaTags.appendChild(pill);

            const opt = document.createElement('option');
            opt.value = val;
            opt.textContent = val;
            opt.selected = true;
            opt.setAttribute('selected', 'selected');
            hiddenAreaSelect.appendChild(opt);
        });

        if (selectedAreas.size > 0) {
            areaClear.style.display = 'block';
            areaInput.placeholder = 'Ketik untuk menambah Area...';
        } else {
            areaClear.style.display = 'none';
            areaInput.placeholder = 'Ketik untuk mencari Area...';
        }
    }

    // Update Dropdown AREA berdasarkan Region yang dipilih (DEPENDENCY LOGIC)
    function updateAreaOptions(preservedAreas = null) {
        // Tentukan kota target
        const targetCities = new Set();
        selectedRegions.forEach(reg => {
            if (MACRO_REGION_MAP[reg]) {
                MACRO_REGION_MAP[reg].forEach(c => targetCities.add(c));
            } else if (IDA_REGION_AREA_MAP[reg]) {
                targetCities.add(reg);
            }
        });

        areaDropdown.innerHTML = '';

        if (targetCities.size === 0) {
            areaInput.disabled = true;
            areaInput.placeholder = 'Pilih Region terlebih dahulu...';
            areaBox.classList.remove('bg-white');
            areaBox.classList.add('bg-light');
            areaClear.style.display = 'none';
            selectedAreas.clear();
            renderAreaTags();

            if (areaNotice) {
                areaNotice.className = 'text-muted fs-11 fw-normal';
                areaNotice.textContent = 'Otomatis menyesuaikan dengan Region yang dipilih';
            }

            areaDropdown.innerHTML = '<div class="p-3 text-center text-muted fs-12">Silakan pilih Region di atas terlebih dahulu.</div>';
            return;
        }

        // Aktifkan Area input
        areaInput.disabled = false;
        areaBox.classList.remove('bg-light');
        areaBox.classList.add('bg-white');

        if (areaNotice) {
            areaNotice.className = 'text-success fs-11 fw-semibold';
            areaNotice.textContent = `${targetCities.size} Region dipilih: Menampilkan pilihan area turunan`;
        }

        // Hapus area yang kotanya sudah tidak dipilih lagi
        const validAvailableAreas = new Set();
        targetCities.forEach(city => {
            (IDA_REGION_AREA_MAP[city] || []).forEach(a => validAvailableAreas.add(a));
        });

        if (preservedAreas && Array.isArray(preservedAreas)) {
            preservedAreas.forEach(a => {
                if (validAvailableAreas.has(a)) selectedAreas.add(a);
            });
        } else {
            selectedAreas.forEach(a => {
                if (!validAvailableAreas.has(a)) selectedAreas.delete(a);
            });
        }

        renderAreaTags();

        // Populate Area dropdown
        targetCities.forEach(city => {
            const areas = IDA_REGION_AREA_MAP[city] || [];
            if (areas.length > 0) {
                const groupHeader = document.createElement('div');
                groupHeader.className = 'ida-optgroup-header';
                groupHeader.textContent = `Area di ${city}`;
                areaDropdown.appendChild(groupHeader);

                areas.forEach(areaName => {
                    const optItem = document.createElement('div');
                    optItem.className = 'ida-option-item';
                    optItem.dataset.value = areaName;
                    optItem.dataset.label = areaName.toLowerCase();

                    const isSelected = selectedAreas.has(areaName);
                    if (isSelected) optItem.classList.add('selected');

                    optItem.innerHTML = `
                        <span>${areaName}</span>
                        ${isSelected ? '<i class="ri-check-line fw-bold fs-14" style="color: #fe7d00;"></i>' : ''}
                    `;

                    optItem.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (selectedAreas.has(areaName)) {
                            selectedAreas.delete(areaName);
                        } else {
                            selectedAreas.add(areaName);
                        }
                        areaInput.value = '';
                        renderAreaTags();
                        updateAreaOptions();
                        areaInput.focus();
                    });

                    areaDropdown.appendChild(optItem);
                });
            }
        });
    }

    // Filter pencarian AREA
    function filterAreaDropdown(query) {
        const q = (query || '').toLowerCase().trim();
        let matchCount = 0;

        const headers = areaDropdown.querySelectorAll('.ida-optgroup-header');
        headers.forEach(header => {
            let nextEl = header.nextElementSibling;
            let groupHasMatch = false;

            while (nextEl && nextEl.classList.contains('ida-option-item')) {
                const text = nextEl.dataset.label || '';
                if (!q || text.includes(q)) {
                    nextEl.style.display = 'flex';
                    groupHasMatch = true;
                    matchCount++;
                } else {
                    nextEl.style.display = 'none';
                }
                nextEl = nextEl.nextElementSibling;
            }

            header.style.display = groupHasMatch ? 'block' : 'none';
        });

        const existingNoRes = areaDropdown.querySelector('.ida-no-results');
        if (existingNoRes) existingNoRes.remove();

        if (matchCount === 0) {
            const noRes = document.createElement('div');
            noRes.className = 'ida-no-results p-3 text-center text-muted fs-12';
            noRes.textContent = `Tidak ada Area yang cocok dengan "${query}"`;
            areaDropdown.appendChild(noRes);
        }
    }

    // Smart Positioning Helper (Prevents dropdown from getting cut off at bottom)
    function smartPositionDropdown(box, dropdown) {
        const boxRect = box.getBoundingClientRect();
        const modalBody = box.closest('.modal-body') || document.querySelector('#idaCampaignFilterModal .modal-body');
        const bodyRect = modalBody ? modalBody.getBoundingClientRect() : { bottom: window.innerHeight, top: 0 };
        
        const spaceBelow = bodyRect.bottom - boxRect.bottom;
        const spaceAbove = boxRect.top - bodyRect.top;

        if (spaceBelow < 240 && spaceAbove > 180) {
            dropdown.style.top = 'auto';
            dropdown.style.bottom = '100%';
            dropdown.style.marginTop = '0';
            dropdown.style.marginBottom = '4px';
            dropdown.style.boxShadow = '0 -10px 25px rgba(0,0,0,0.15)';
        } else {
            dropdown.style.top = '100%';
            dropdown.style.bottom = 'auto';
            dropdown.style.marginTop = '4px';
            dropdown.style.marginBottom = '0';
            dropdown.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
        }
    }

    // REGION Event Listeners
    regionBox.addEventListener('click', function() {
        regionBox.classList.add('focused');
        smartPositionDropdown(regionBox, regionDropdown);
        regionDropdown.style.display = 'block';
        areaDropdown.style.display = 'none';
        if (interestDropdown) interestDropdown.style.display = 'none';
        regionInput.focus();
    });

    regionInput.addEventListener('focus', function() {
        regionBox.classList.add('focused');
        smartPositionDropdown(regionBox, regionDropdown);
        regionDropdown.style.display = 'block';
        filterRegionDropdown(regionInput.value);
    });

    regionInput.addEventListener('input', function() {
        smartPositionDropdown(regionBox, regionDropdown);
        regionDropdown.style.display = 'block';
        filterRegionDropdown(regionInput.value);
    });

    regionInput.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !regionInput.value && selectedRegions.size > 0) {
            const lastVal = Array.from(selectedRegions).pop();
            selectedRegions.delete(lastVal);
            renderRegionTags();
            updateAreaOptions();
            populateRegionDropdown();
        } else if (e.key === 'Escape') {
            regionDropdown.style.display = 'none';
            regionBox.classList.remove('focused');
        }
    });

    regionClear.addEventListener('click', function(e) {
        e.stopPropagation();
        selectedRegions.clear();
        regionInput.value = '';
        renderRegionTags();
        populateRegionDropdown();
        updateAreaOptions();
        regionInput.focus();
    });

    // AREA Event Listeners
    areaBox.addEventListener('click', function() {
        if (areaInput.disabled) return;
        areaBox.classList.add('focused');
        smartPositionDropdown(areaBox, areaDropdown);
        areaDropdown.style.display = 'block';
        regionDropdown.style.display = 'none';
        if (interestDropdown) interestDropdown.style.display = 'none';
        areaInput.focus();
    });

    areaInput.addEventListener('focus', function() {
        if (areaInput.disabled) return;
        areaBox.classList.add('focused');
        smartPositionDropdown(areaBox, areaDropdown);
        areaDropdown.style.display = 'block';
        filterAreaDropdown(areaInput.value);
    });

    areaInput.addEventListener('input', function() {
        smartPositionDropdown(areaBox, areaDropdown);
        areaDropdown.style.display = 'block';
        filterAreaDropdown(areaInput.value);
    });

    areaInput.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !areaInput.value && selectedAreas.size > 0) {
            const lastVal = Array.from(selectedAreas).pop();
            selectedAreas.delete(lastVal);
            renderAreaTags();
            updateAreaOptions();
        } else if (e.key === 'Escape') {
            areaDropdown.style.display = 'none';
            areaBox.classList.remove('focused');
        }
    });

    areaClear.addEventListener('click', function(e) {
        e.stopPropagation();
        selectedAreas.clear();
        areaInput.value = '';
        renderAreaTags();
        updateAreaOptions();
        areaInput.focus();
    });

    // ==========================================
    // INTEREST MULTI-SELECT FUNCTIONS & LOGIC
    // ==========================================
    function renderInterestTags() {
        if (!interestTags || !hiddenInterestSelect) return;
        interestTags.innerHTML = '';
        hiddenInterestSelect.innerHTML = '';

        selectedInterests.forEach(val => {
            const pill = createTagPill(val, val, function(v) {
                selectedInterests.delete(v);
                renderInterestTags();
                populateInterestDropdown();
            });
            interestTags.appendChild(pill);

            const opt = document.createElement('option');
            opt.value = val;
            opt.selected = true;
            hiddenInterestSelect.appendChild(opt);
        });

        if (selectedInterests.size > 0) {
            interestClear.style.display = 'block';
            interestInput.placeholder = 'Ketik untuk menambah Minat...';
        } else {
            interestClear.style.display = 'none';
            interestInput.placeholder = 'Ketik atau pilih minat (e.g: Crypto, Automotive, Fashion)...';
        }
    }

    function populateInterestDropdown() {
        if (!interestDropdown) return;
        interestDropdown.innerHTML = '';
        for (const [groupLabel, items] of Object.entries(IDA_INTEREST_CATEGORIES)) {
            const groupHeader = document.createElement('div');
            groupHeader.className = 'ida-optgroup-header';
            groupHeader.textContent = groupLabel;
            interestDropdown.appendChild(groupHeader);

            items.forEach(item => {
                const optItem = document.createElement('div');
                optItem.className = 'ida-option-item';
                optItem.dataset.value = item;
                optItem.dataset.label = item.toLowerCase();

                const isSelected = selectedInterests.has(item);
                if (isSelected) optItem.classList.add('selected');

                optItem.innerHTML = `
                    <span>${item}</span>
                    ${isSelected ? '<i class="ri-check-line fw-bold fs-14" style="color: #fe7d00;"></i>' : ''}
                `;

                optItem.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (selectedInterests.has(item)) {
                        selectedInterests.delete(item);
                    } else {
                        selectedInterests.add(item);
                    }
                    interestInput.value = '';
                    renderInterestTags();
                    populateInterestDropdown();
                    interestInput.focus();
                });

                interestDropdown.appendChild(optItem);
            });
        }
    }

    function filterInterestDropdown(query) {
        if (!interestDropdown) return;
        const q = (query || '').toLowerCase().trim();
        let matchCount = 0;

        const headers = interestDropdown.querySelectorAll('.ida-optgroup-header');
        headers.forEach(header => {
            let nextEl = header.nextElementSibling;
            let groupHasMatch = false;

            while (nextEl && nextEl.classList.contains('ida-option-item')) {
                const text = nextEl.dataset.label || '';
                if (!q || text.includes(q)) {
                    nextEl.style.display = 'flex';
                    groupHasMatch = true;
                    matchCount++;
                } else {
                    nextEl.style.display = 'none';
                }
                nextEl = nextEl.nextElementSibling;
            }

            header.style.display = groupHasMatch ? 'block' : 'none';
        });

        const existingNoRes = interestDropdown.querySelector('.ida-no-results');
        if (existingNoRes) existingNoRes.remove();

        if (matchCount === 0) {
            const noRes = document.createElement('div');
            noRes.className = 'ida-no-results p-3 text-center text-muted fs-12';
            noRes.textContent = `Tidak ada minat yang cocok dengan "${query}"`;
            interestDropdown.appendChild(noRes);
        }
    }

    // INTEREST Event Listeners
    if (interestBox && interestInput) {
        interestBox.addEventListener('click', function() {
            interestBox.classList.add('focused');
            smartPositionDropdown(interestBox, interestDropdown);
            interestDropdown.style.display = 'block';
            regionDropdown.style.display = 'none';
            areaDropdown.style.display = 'none';
            interestInput.focus();
        });

        interestInput.addEventListener('focus', function() {
            interestBox.classList.add('focused');
            smartPositionDropdown(interestBox, interestDropdown);
            interestDropdown.style.display = 'block';
            filterInterestDropdown(interestInput.value);
        });

        interestInput.addEventListener('input', function() {
            smartPositionDropdown(interestBox, interestDropdown);
            interestDropdown.style.display = 'block';
            filterInterestDropdown(interestInput.value);
        });

        interestInput.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !interestInput.value && selectedInterests.size > 0) {
                const lastVal = Array.from(selectedInterests).pop();
                selectedInterests.delete(lastVal);
                renderInterestTags();
                populateInterestDropdown();
            } else if (e.key === 'Escape') {
                interestDropdown.style.display = 'none';
                interestBox.classList.remove('focused');
            }
        });

        interestClear.addEventListener('click', function(e) {
            e.stopPropagation();
            selectedInterests.clear();
            interestInput.value = '';
            renderInterestTags();
            populateInterestDropdown();
            interestInput.focus();
        });
    }

    // Close Dropdowns on Click Outside
    document.addEventListener('click', function(e) {
        if (!regionBox.contains(e.target) && !regionDropdown.contains(e.target)) {
            regionDropdown.style.display = 'none';
            regionBox.classList.remove('focused');
        }
        if (!areaBox.contains(e.target) && !areaDropdown.contains(e.target)) {
            areaDropdown.style.display = 'none';
            areaBox.classList.remove('focused');
        }
        if (interestBox && !interestBox.contains(e.target) && !interestDropdown.contains(e.target)) {
            interestDropdown.style.display = 'none';
            interestBox.classList.remove('focused');
        }
    });

    // Global Helper untuk repopulate dari config tersimpan
    window.updateIdaRegionAndArea = function(regions, areas) {
        selectedRegions.clear();
        (Array.isArray(regions) ? regions : (regions ? [regions] : [])).forEach(r => selectedRegions.add(r));
        renderRegionTags();
        populateRegionDropdown();

        const preserved = Array.isArray(areas) ? areas : (areas ? [areas] : []);
        updateAreaOptions(preserved);
    };

    window.updateIdaInterests = function(interests) {
        selectedInterests.clear();
        (Array.isArray(interests) ? interests : (interests ? [interests] : [])).forEach(i => selectedInterests.add(i));
        renderInterestTags();
        populateInterestDropdown();
    };

    // Initialize Component On Load
    populateRegionDropdown();
    renderRegionTags();
    updateAreaOptions();
    populateInterestDropdown();
    renderInterestTags();
})();
</script>
