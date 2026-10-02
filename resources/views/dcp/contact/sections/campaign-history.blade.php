<div id="contact-cdp-campaign_history_wrapper">
    <!-- TOP TOOLBAR: MATCHING MARKETING CHILD TAB STYLE -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm text-muted border" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                    <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fs-12" href="javascript:void(0);"><i class="ri-download-line me-1"></i>Export Campaign Log</a></li>
                    <li><a class="dropdown-item fs-12" href="javascript:void(0);"><i class="ri-refresh-line me-1"></i>Refresh Data</a></li>
                </ul>
            </div>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <div class="input-group input-group-sm" style="width: 220px;">
                <input type="text" class="form-control form-control-sm" placeholder="Search" onkeyup="var val = this.value.toLowerCase(); document.querySelectorAll('#contact-cdp-campaign_table tbody tr').forEach(function(r){ r.style.display = r.innerText.toLowerCase().includes(val) ? '' : 'none'; });">
                <span class="input-group-text bg-white text-muted border-start-0"><i class="ri-search-line"></i></span>
            </div>
            <button class="btn btn-light btn-sm text-muted border" type="button" onclick="location.reload();" title="Refresh">
                <i class="ri-refresh-line"></i>
            </button>
        </div>
    </div>

    <!-- TABLE: MATCHING MARKETING CHILD TAB STYLE -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-12 solar-table" id="contact-cdp-campaign_table">
            <thead>
                <tr class="border-bottom text-muted">
                    <th style="width: 40px;" class="text-center">#</th>
                    <th>Campaign</th>
                    <th style="width: 130px;">Channel</th>
                    <th style="width: 180px;">Targeting Method</th>
                    <th style="width: 130px;">Status</th>
                    <th style="width: 170px;">Dispatched At</th>
                    <th style="width: 100px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaignHistory as $index => $camp)
                    <tr class="border-bottom">
                        <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark fs-12">{{ $camp->title }}</div>
                            <span class="fs-11 text-muted">ID: {{ $camp->blast_id }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success-transparent text-success border border-success border-opacity-25 fs-11 py-1 px-2">
                                <i class="ri-whatsapp-line me-1"></i>WhatsApp
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info-transparent text-info border border-info border-opacity-25 fs-11 py-1 px-2">
                                <i class="ri-filter-3-line me-1"></i>CDP Segmentation
                            </span>
                        </td>
                        <td>
                            @php
                                $stName = $camp->status_name ?? 'Delivered';
                                $stColor = $camp->status_color ?? 'success';
                            @endphp
                            <span class="badge bg-{{ $stColor }}-transparent text-{{ $stColor }} fs-11 py-1 px-2">
                                <i class="ri-checkbox-circle-line me-1"></i>{{ $stName }}
                            </span>
                        </td>
                        <td class="text-muted">
                            <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($camp->created_at)->format('d M Y') }}</div>
                            <span class="fs-11 text-muted">{{ \Carbon\Carbon::parse($camp->created_at)->format('H:i') }} WIB</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('dcp.campaign.whatsapp.edit', ['id' => $camp->blast_id]) }}" class="btn btn-sm btn-outline-primary py-1 px-2 fs-11">
                                <i class="ri-eye-line me-1"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="avatar avatar-md bg-light text-muted rounded-circle mx-auto mb-2">
                                <i class="ri-inbox-line fs-20"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Belum Ada Riwayat Campaign</h6>
                            <p class="fs-12 text-muted mb-0">Kontak ini belum pernah ditargetkan dalam broadcast WhatsApp maupun Email blast.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- FOOTER: MATCHING MARKETING CHILD TAB PAGINATION -->
    <div class="d-flex justify-content-between align-items-center mt-3 pt-2">
        <span class="fs-12 text-muted">
            Showing 1 to {{ count($campaignHistory) }} of {{ count($campaignHistory) }} entries
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
