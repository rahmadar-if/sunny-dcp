<x-core::page.list
    id="wa-blast"
    title="WhatsApp Blast"
    class="table-hover"
    :breadcrumbs="$breadcrumbs"
    model="WaBlast"
    package="marketing"
    path="wa-blast/list-index"
    mode="card"
    length="12"
    :card_wrapper="false"
    new="@wa-blast-modal"
    extend_columns="priority,created_by,status,total_audience,total_success,total_read"
    export folder lazy>
    
    <x-slot:table-column class="d-none">
        <x-core::table-column data="title" searchable orderable></x-table-column>
    </x-slot>

    @push('modal-content')
        @include("marketing::pages.wa-blast.modal")
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const targetBase = '{{ url("/dcp/campaign/whatsapp/edit") }}';

            function rewriteLinks() {
                document.querySelectorAll('a[href*="/marketing/wa-blast/edit/"], a[href*="/marketing/email-blast/edit/"]').forEach(function (el) {
                    const href = el.getAttribute('href');
                    if (href) {
                        const parts = href.split(/\/edit\//);
                        if (parts[1]) {
                            el.setAttribute('href', targetBase + '/' + parts[1]);
                        }
                    }
                });
            }

            // Capture click on any link or button pointing to campaign edit
            document.addEventListener('click', function (e) {
                const a = e.target.closest('a');
                if (a && a.href) {
                    if (a.href.includes('/marketing/wa-blast/edit/') || a.href.includes('/marketing/email-blast/edit/')) {
                        e.preventDefault();
                        e.stopPropagation();
                        const parts = a.href.split(/\/edit\//);
                        if (parts[1]) {
                            window.location.href = targetBase + '/' + parts[1];
                        }
                    }
                }
            }, true);

            // Capture double click on cards or rows
            document.addEventListener('dblclick', function (e) {
                const card = e.target.closest('tr, .solar-card-item');
                if (card) {
                    const a = card.querySelector('a[href*="/edit/"]');
                    if (a && a.href) {
                        e.preventDefault();
                        e.stopPropagation();
                        const parts = a.href.split(/\/edit\//);
                        if (parts[1]) {
                            window.location.href = targetBase + '/' + parts[1];
                        }
                    }
                }
            }, true);

            // Observe DOM mutations to rewrite URLs immediately as datatables/cards are loaded
            const observer = new MutationObserver(function () {
                rewriteLinks();
            });
            observer.observe(document.body, { childList: true, subtree: true });
            rewriteLinks();
        });
    </script>
    @endpush

</x-core::page.list>
