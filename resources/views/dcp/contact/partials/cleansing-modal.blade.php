<!-- CLEANSING DATA & BATCH ENRICHMENT MODAL (Manual CRM Tab) -->
<div class="modal fade" id="modalCleansingData" tabindex="-1" aria-labelledby="modalCleansingDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 bg-warning text-white rounded-3 fs-16 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-magic-line"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-dark mb-0" id="modalCleansingDataLabel">Data Cleansing & Batch Enrichment</h6>
                        <span class="text-muted fs-11">Standardisasi data manual sebelum integrasi Telco Intelligence</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Info Banner -->
                {{-- <div class="alert alert-primary-light d-flex align-items-start gap-2 mb-3 border border-primary border-opacity-25 py-2">
                    <i class="ri-information-line fs-18 text-primary flex-shrink-0 mt-1"></i>
                    <div class="fs-12 text-dark">
                        <strong>Validasi Telco Gateway:</strong> Fitur Cleansing akan memverifikasi keaktifan nomor MSISDN, menstandarisasi format kontak (+62), serta langsung menarik profil demografi, credit score, dan daya beli dari data provider.
                    </div>
                </div> --}}

                <!-- Selected Contacts Count and List -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fs-12 fw-bold text-uppercase text-muted">
                            Kontak Terpilih (<span id="modalCleansingCountText">0</span> Kontak)
                        </span>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 fs-11" id="btnClearSelectedCleansing">
                            Batal Pilih Semua
                        </button>
                    </div>

                    <!-- Scrollable Container of Selected Contacts -->
                    <div id="modalCleansingContactsList" class="p-2 bg-light rounded-3 border" style="max-height: 180px; overflow-y: auto;">
                        <!-- Injected via JavaScript -->
                    </div>
                </div>

                <!-- Parameter Cleansing & Pengecekan Telco (Simple style like Request Enrich) -->
                <div class="mb-3 p-3 bg-light rounded-3 border">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fs-12 fw-semibold text-dark mb-0">Parameter Cleansing & Pengecekan Telco:</label>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 fs-11" id="btnToggleAllCleansingParams">
                            Pilih Semua
                        </button>
                    </div>

                    <div class="row g-2 pt-1">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input cleansing-option-check" type="checkbox" name="cleansing_params[]" value="network" id="cleanParamNetwork" checked>
                                <label class="form-check-label fs-13 text-dark fw-medium" for="cleanParamNetwork">
                                    Keaktifan Nomor (HLR)
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input cleansing-option-check" type="checkbox" name="cleansing_params[]" value="credit_score" id="cleanParamCredit">
                                <label class="form-check-label fs-13 text-dark fw-medium" for="cleanParamCredit">
                                    Kredit Score
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input cleansing-option-check" type="checkbox" name="cleansing_params[]" value="gambling" id="cleanParamGambling">
                                <label class="form-check-label fs-13 text-dark fw-medium" for="cleanParamGambling">
                                    Deteksi Gambling
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input cleansing-option-check" type="checkbox" name="cleansing_params[]" value="format" id="cleanParamFormat">
                                <label class="form-check-label fs-13 text-dark fw-medium" for="cleanParamFormat">
                                    Format Cleansing (+62)
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input cleansing-option-check" type="checkbox" name="cleansing_params[]" value="buying_power" id="cleanParamBuyingPower">
                                <label class="form-check-label fs-13 text-dark fw-medium" for="cleanParamBuyingPower">
                                    Daya Beli (SES)
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input cleansing-option-check" type="checkbox" name="cleansing_params[]" value="device_location" id="cleanParamDevice">
                                <label class="form-check-label fs-13 text-dark fw-medium" for="cleanParamDevice">
                                    Device & Lokasi
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Animated Progress Box -->
                <div id="batchCleansingProgressBox" class="p-3 bg-light rounded-3 border d-none">
                    <div class="d-flex justify-content-between align-items-center mb-1 fs-12">
                        <span class="fw-medium text-dark" id="batchCleansingProgressText">
                            <span class="spinner-border spinner-border-sm text-warning me-1"></span>
                            Memvalidasi MSISDN ke Telco Gateway...
                        </span>
                        <span class="fw-bold text-warning" id="batchCleansingProgressPct">0%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" id="batchCleansingProgressBar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light py-2 px-4 border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btnCancelBatchCleansing">Batal</button>
                <button type="button" class="btn btn-warning d-flex align-items-center gap-1 px-3 text-white fw-medium" id="btnConfirmBatchCleansing">
                    <i class="ri-radar-line"></i>
                    <span>Lanjutkan Enrich Data Terpilih</span>
                </button>
            </div>
        </div>
    </div>
</div>
