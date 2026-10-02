<div id="contact-cdp-enrichment_history_wrapper">
    <!-- TOP TOOLBAR: MATCHING MARKETING CHILD TAB STYLE -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm text-muted border" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                    <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fs-12" href="javascript:void(0);"><i class="ri-shield-keyhole-line me-1"></i>UU PDP Compliance Certificate</a></li>
                    <li><a class="dropdown-item fs-12" href="javascript:void(0);"><i class="ri-download-line me-1"></i>Export Audit Trail Log</a></li>
                </ul>
            </div>
            <span class="badge bg-success-transparent text-success border border-success border-opacity-25 fs-11 py-1 px-2">
                <i class="ri-shield-check-line me-1"></i>UU PDP No. 27/2022 Compliant Log
            </span>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <div class="input-group input-group-sm" style="width: 220px;">
                <input type="text" class="form-control form-control-sm" placeholder="Search" onkeyup="var val = this.value.toLowerCase(); document.querySelectorAll('#contact-cdp-enrichment_table tbody tr').forEach(function(r){ r.style.display = r.innerText.toLowerCase().includes(val) ? '' : 'none'; });">
                <span class="input-group-text bg-white text-muted border-start-0"><i class="ri-search-line"></i></span>
            </div>
            <button class="btn btn-light btn-sm text-muted border" type="button" onclick="location.reload();" title="Refresh">
                <i class="ri-refresh-line"></i>
            </button>
        </div>
    </div>

    <!-- TABLE: MATCHING MARKETING CHILD TAB STYLE -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-12 solar-table" id="contact-cdp-enrichment_table">
            <thead>
                <tr class="border-bottom text-muted">
                    <th style="width: 40px;" class="text-center">#</th>
                    <th style="width: 160px;">Timestamp</th>
                    <th style="width: 250px;">Event / Activity</th>
                    <th>Audit Trail Details & Attributes</th>
                    <th style="width: 170px;">Compliance & Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrichmentHistory as $index => $item)
                    <tr class="border-bottom">
                        <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $item['timestamp'] }}</div>
                            <span class="fs-11 text-muted">Gateway Sync</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-{{ $item['icon_color'] ?? 'primary' }}-transparent text-{{ $item['icon_color'] ?? 'primary' }} rounded-circle flex-shrink-0">
                                    <i class="{{ $item['icon'] ?? 'ri-checkbox-circle-line' }} fs-12"></i>
                                </div>
                                <div class="fw-bold text-dark fs-12">{{ $item['title'] }}</div>
                            </div>
                        </td>
                        <td>
                            <p class="mb-0 text-muted fs-12 lh-base">{{ $item['description'] }}</p>
                        </td>
                        <td>
                            <span class="badge bg-{{ $item['badge_color'] ?? 'light' }}-transparent text-{{ $item['badge_color'] ?? 'dark' }} border border-{{ $item['badge_color'] ?? 'secondary' }} border-opacity-25 fs-11 py-1 px-2">
                                {{ $item['badge'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="avatar avatar-md bg-light text-muted rounded-circle mx-auto mb-2">
                                <i class="ri-shield-line fs-20"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Belum Ada Log Audit Trail</h6>
                            <p class="fs-12 text-muted mb-0">Kontak ini belum tersinkronisasi dengan jaringan telco / CDP Enrichment Gateway.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- FOOTER: MATCHING MARKETING CHILD TAB PAGINATION -->
    <div class="d-flex justify-content-between align-items-center mt-3 pt-2">
        <span class="fs-12 text-muted">
            Showing 1 to {{ count($enrichmentHistory) }} of {{ count($enrichmentHistory) }} entries
        </span>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Prev</a></li>
                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
