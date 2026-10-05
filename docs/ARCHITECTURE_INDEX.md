# SunnyCRM Architecture & Route Index

Dokumen ini adalah **peta navigasi cepat (Fast Index)** untuk AI dan developer agar tracing / perbaikan bug dapat langsung menuju ke file target tanpa eksplorasi berulang.

---

## 1. Quick Route & Flow Mapping (DCP & Modules)

| Modul / Fitur | URL / Route Name | Controller & Method | View / Blade Component | Model / Service Terkait |
| :--- | :--- | :--- | :--- | :--- |
| **Contact (List)** | `GET /dcp/contact`<br>`name: dcp.contact` | [`ContactController@index`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/ContactController.php) | [`resources/views/dcp/contact/list.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/list.blade.php) | [`Solaris\BaseCRM\Models\Contact`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/vendor/solaris/solaris-laravel-basecrm) |
| **Contact (Detail/Edit)** | `GET /dcp/contact/edit/{id}`<br>`name: dcp.contact.edit` | [`ContactController@edit`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/ContactController.php) | [`resources/views/dcp/contact/page.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/page.blade.php)<br>&bull; [`cdp.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/sections/cdp.blade.php) (Child Tabs)<br>&bull; [`cdp-insights.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/sections/cdp-insights.blade.php)<br>&bull; [`campaign-history.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/sections/campaign-history.blade.php)<br>&bull; [`enrichment-history.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/sections/enrichment-history.blade.php) | [`DcpCustomerProfile`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Models/DcpCustomerProfile.php) |
| **Contact (Profile Drawer API)** | `GET /dcp/contact/profile/{id}`<br>`name: dcp.contact.profile` | [`ContactController@getProfile`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/ContactController.php) | [`resources/views/dcp/contact/partials/detail-drawer.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/partials/detail-drawer.blade.php) | [`DcpCustomerProfile`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Models/DcpCustomerProfile.php) |
| **Contact (Single Enrich API)** | `POST /dcp/contact/{id}/enrich`<br>`name: dcp.contact.enrich` | [`ContactController@enrichContact`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/ContactController.php) | Triggered via `Enrich` button on Manual Contact row | [`DcpCustomerProfile`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Models/DcpCustomerProfile.php) |
| **Contact (Cleansing Data & Batch Enrich)** | Triggered on Manual CRM tab | [`ContactController@enrichContact`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/ContactController.php) | [`resources/views/dcp/contact/partials/cleansing-modal.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/partials/cleansing-modal.blade.php) | [`DcpCustomerProfile`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Models/DcpCustomerProfile.php) |
| **Contact (Enrichment Filter API)** | `POST /dcp/contact/apply-enrichment-filter`<br>`name: dcp.contact.filter` | [`ContactController@applyFilter`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/ContactController.php) | [`resources/views/dcp/contact/partials/enrichment-filter-modal.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/contact/partials/enrichment-filter-modal.blade.php) | [`IdaService`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Services/Indosat/IdaService.php) |
| **Email Campaign & Blast** | `GET /dcp/campaign`<br>`name: dcp.campaign` | Closure in [`routes/modules.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/routes/modules.php#L29) | `Helper::view("email_blast.list")` | Marketing Package |
| **WhatsApp Blast (List)** | `GET /dcp/campaign/whatsapp`<br>`name: dcp.campaign.whatsapp` | Closure in [`routes/modules.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/routes/modules.php#L46) | [`resources/views/dcp/campaign/whatsapp-list.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/campaign/whatsapp-list.blade.php) | Marketing Package |
| **WhatsApp Blast (Detail/Edit)** | `GET /dcp/campaign/whatsapp/edit/{id}`<br>`name: dcp.campaign.whatsapp.edit` | [`IdaCampaignController@showCampaign`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/IdaCampaignController.php) | [`resources/views/wa-blast/page.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/wa-blast/page.blade.php) | Marketing Package |
| **IDA Campaign Config** | `GET /dcp/campaign/ida/{blastId}`<br>`name: dcp.campaign.ida.get` | [`IdaCampaignController@getConfig`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/IdaCampaignController.php) | [`resources/views/dcp/campaign/ida-modal.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/campaign/ida-modal.blade.php) & [`ida-tab.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/campaign/ida-tab.blade.php) | [`DcpCampaignIdaConfig`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Models/DcpCampaignIdaConfig.php), [`IdaService`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Services/Indosat/IdaService.php) |
| **IDA Filter Apply** | `POST /dcp/campaign/ida/{blastId}/apply-filter` | [`IdaCampaignController@applyFilter`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/IdaCampaignController.php) | AJAX Endpoint | [`IdaService`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Services/Indosat/IdaService.php) |
| **IDA Simulate Consent** | `POST /dcp/campaign/ida/{blastId}/simulate-consent` | [`IdaCampaignController@simulateConsent`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/IdaCampaignController.php) | AJAX Endpoint | [`IdaService`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Services/Indosat/IdaService.php) |
| **IDA Push Audience** | `POST /dcp/campaign/ida/{blastId}/push-audience` | [`IdaCampaignController@pushToAudience`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/IdaCampaignController.php) | AJAX Endpoint | [`IdaService`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Services/Indosat/IdaService.php) |
| **Legacy Enrichment Redirect** | `GET /dcp/enrichment`, `cleansing`, `research` | Fallback closure in [`routes/modules.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/routes/modules.php) | Redirects to `dcp.contact` | - |
| **Sunny AI Chat (Component)** | Reusable Blade Component `<x-sunny-ai-chat />` | - | [`resources/views/components/sunny-ai-chat.blade.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/components/sunny-ai-chat.blade.php) | Floating AI prompt with `/search`, `/report`, `/summary` |

---

## 2. Directory Layout Reference

- **Custom Routes**: [`routes/modules.php`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/routes/modules.php) (di-load via `routes/web.php` dalam middleware `auth` & `menu.access`)
- **DCP Controllers**: [`app/Http/Controllers/Dcp/`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Http/Controllers/Dcp/)
- **DCP Models**: [`app/Models/`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Models/)
- **DCP Services**: [`app/Services/Indosat/`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/app/Services/Indosat/)
- **Custom Views**: [`resources/views/dcp/`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/dcp/) dan [`resources/views/wa-blast/`](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/resources/views/wa-blast/)

---

## 3. Aturan Tambahan Pemeliharaan Index
- Setiap ada modul baru atau modifikasi alur/routing, perbarui tabel di dokumen ini agar tracing berikutnya instan tanpa re-scan codebase.
