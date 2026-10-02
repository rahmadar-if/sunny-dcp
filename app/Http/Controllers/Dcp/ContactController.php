<?php

namespace App\Http\Controllers\Dcp;

use App\Http\Controllers\Controller;
use App\Models\DcpCustomerProfile;
use App\Services\Indosat\IdaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Solaris\Core\Helpers\Helper;

class ContactController extends Controller
{
    protected $repo;
    protected IdaService $idaService;

    public function __construct(IdaService $idaService)
    {
        $this->repo = new (Helper::repository('contact'))(new (Helper::model('contact')));
        $this->idaService = $idaService;
    }

    /**
     * Contact list with CDP enrichment intelligence
     */
    public function index(): View
    {
        $breadcrumbs = [
            ['label' => 'CDP'],
            ['label' => 'Contact'],
        ];

        // Preload all customer profiles keyed by contact_id and phone_number
        $profiles = DcpCustomerProfile::all();
        $enrichedMap = [];
        foreach ($profiles as $p) {
            if ($p->contact_id) {
                $enrichedMap[$p->contact_id] = $p;
            }
            $cleanPhone = preg_replace('/[^0-9]/', '', $p->phone_number ?? '');
            if ($cleanPhone) {
                $enrichedMap['phone_' . $cleanPhone] = $p;
            }
            $cleanName = strtolower(trim($p->name));
            if ($cleanName) {
                $enrichedMap['name_' . $cleanName] = $p;
            }
        }

        $allContacts = Helper::model('contact')::all();
        $enrichedCount = 0;
        $manualCount = 0;

        foreach ($allContacts as $c) {
            $cPhone = preg_replace('/[^0-9]/', '', $c->primary_mobile_phone ?? $c->primary_phone ?? '');
            $cName = strtolower(trim($c->name));
            $p = $enrichedMap[$c->id] ?? ($cPhone ? ($enrichedMap['phone_' . $cPhone] ?? null) : null) ?? ($cName ? ($enrichedMap['name_' . $cName] ?? null) : null);
            if ($p && $p->enrichment_status === 'Enriched' && $p->phone_status !== 'Inactive') {
                $enrichedCount++;
            } else {
                $manualCount++;
            }
        }

        $stats = [
            'total' => $allContacts->count(),
            'enriched' => $enrichedCount,
            'manual' => $manualCount,
        ];

        return view('dcp.contact.list', [
            'breadcrumbs' => $breadcrumbs,
            'profiles' => $profiles,
            'enrichedMap' => $enrichedMap,
            'stats' => $stats,
        ]);
    }

    /**
     * Show contact detail/edit with CDP Insights tab
     */
    public function edit(string $id): View
    {
        $data = $this->repo->findComplete($id, $this->extendColumns());
        
        $breadcrumbs = [
            ['label' => 'CDP'],
            ['label' => 'Contact'],
            ['label' => $data?->name ?? 'Detail'],
        ];

        // Find associated CDP Customer Profile
        $cdpProfile = DcpCustomerProfile::where('contact_id', $id)->first();
        if (!$cdpProfile && $data) {
            $cPhone = preg_replace('/[^0-9]/', '', $data->primary_mobile_phone ?? $data->primary_phone ?? '');
            $cdpProfile = DcpCustomerProfile::where(function ($q) use ($cPhone, $data) {
                if ($cPhone) {
                    $q->where('phone_number', $cPhone);
                }
                if ($data->email) {
                    $q->orWhere('email', $data->email);
                }
                if ($data->name) {
                    $q->orWhere('name', $data->name);
                }
            })->first();
        }

        // Query Campaign History targeting this contact
        $campaignHistory = DB::table('wa_blast_audiences')
            ->join('wa_blasts', 'wa_blasts.id', '=', 'wa_blast_audiences.wa_blast_id')
            ->leftJoin('campaign_blast_statuses', 'campaign_blast_statuses.id', '=', 'wa_blasts.status_id')
            ->where('wa_blast_audiences.contact_id', $id)
            ->select([
                'wa_blasts.id as blast_id',
                'wa_blasts.title',
                'wa_blasts.sent_at',
                'wa_blasts.created_at',
                'wa_blast_audiences.created_at as audience_added_at',
                'campaign_blast_statuses.name as status_name',
                'campaign_blast_statuses.color as status_color',
            ])
            ->orderBy('wa_blasts.created_at', 'desc')
            ->get();

        // Build Enrichment History from POV of this contact
        $enrichmentHistory = [];
        if ($cdpProfile) {
            $enrichmentHistory = [
                [
                    'title' => 'Profile Enriched via CDP Gateway',
                    'timestamp' => $cdpProfile->updated_at ? $cdpProfile->updated_at->format('d M Y, H:i') : '30 Sep 2026, 08:12',
                    'description' => '24 customer profile & behavior attributes enriched through telco & lifestyle intelligence stream with explicit consent (UU PDP No. 27/2022).',
                    'badge' => 'UU PDP Compliant',
                    'badge_color' => 'success',
                    'icon' => 'ri-check-double-line',
                    'icon_color' => 'success',
                ],
                [
                    'title' => 'Network & Device Identity Verified',
                    'timestamp' => $cdpProfile->created_at ? $cdpProfile->created_at->format('d M Y, H:i') : '30 Sep 2026, 08:15',
                    'description' => "MSISDN status confirmed Active on {$cdpProfile->competitor_product_usage}. Hardware signature detected as {$cdpProfile->phone_device_type}.",
                    'badge' => 'Network Active',
                    'badge_color' => 'primary',
                    'icon' => 'ri-smartphone-line',
                    'icon_color' => 'primary',
                ],
                [
                    'title' => 'Credit & Financial Eligibility Computed',
                    'timestamp' => '30 Sep 2026, 08:20',
                    'description' => "Credit score evaluated at {$cdpProfile->credit_score} with {$cdpProfile->payment_history} payment history and {$cdpProfile->fraud_risk} fraud risk level.",
                    'badge' => 'Score ' . $cdpProfile->credit_score,
                    'badge_color' => 'info',
                    'icon' => 'ri-shield-check-line',
                    'icon_color' => 'info',
                ],
                [
                    'title' => 'Campaign Consent Opt-In Recorded',
                    'timestamp' => '30 Sep 2026, 08:25',
                    'description' => 'Explicit customer consent received for personalized WhatsApp promotional communications.',
                    'badge' => 'Opt-In Confirmed',
                    'badge_color' => 'success',
                    'icon' => 'ri-shield-keyhole-line',
                    'icon_color' => 'success',
                ],
            ];
        }

        return view('dcp.contact.page', [
            'data' => $data,
            'breadcrumbs' => $breadcrumbs,
            'cdpProfile' => $cdpProfile,
            'campaignHistory' => $campaignHistory,
            'enrichmentHistory' => $enrichmentHistory,
        ]);
    }

    /**
     * Show contact JSON or redirect
     */
    public function show(Request $request, string $id): RedirectResponse|JsonResponse
    {
        if (!$request->expectsJson()) {
            return redirect(route('dcp.contact.edit', ['id' => $id]));
        }

        return response()->json($this->repo->findComplete($id, $this->extendColumns()));
    }

    /**
     * Get single CDP profile details for the Eye Icon drawer
     */
    public function getProfile(string $id): JsonResponse
    {
        // Try finding by contact_id first, then by profile id
        $profile = DcpCustomerProfile::where('contact_id', $id)->first();
        if (!$profile) {
            $profile = DcpCustomerProfile::find($id);
        }

        if (!$profile) {
            // Check if contact exists to return manual status
            $contact = Helper::model('contact')::find($id);
            if ($contact) {
                $cPhone = preg_replace('/[^0-9]/', '', $contact->primary_mobile_phone ?? $contact->primary_phone ?? '');
                $profile = DcpCustomerProfile::where(function ($q) use ($cPhone, $contact) {
                    if ($cPhone) $q->where('phone_number', $cPhone);
                    if ($contact->name) $q->orWhere('name', $contact->name);
                })->first();

                if (!$profile) {
                    return response()->json([
                        'status' => 'manual',
                        'message' => 'Contact was entered manually in CRM and has not been enriched through CDP yet.',
                        'data' => [
                            'name' => $contact->name,
                            'phone_number' => $contact->primary_mobile_phone ?? $contact->primary_phone ?? '-',
                            'email' => $contact->email ?? '-',
                            'job_title' => $contact->job_title ?? '-',
                            'company' => $contact->account?->name ?? '-',
                            'is_manual' => true,
                        ],
                    ]);
                }
            }
        }

        if (!$profile) {
            return response()->json(['status' => 'error', 'message' => 'Profile not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $profile,
        ]);
    }

    /**
     * Enrich a manual contact on the fly via Telco Gateway simulation
     */
    public function enrichContact(Request $request, string $id): JsonResponse
    {
        $contact = Helper::model('contact')::find($id);
        if (!$contact) {
            return response()->json(['status' => 'error', 'message' => 'Contact not found'], 404);
        }

        $rawPhone = $contact->primary_mobile_phone ?? $contact->primary_phone ?? '';
        $cPhone = preg_replace('/[^0-9]/', '', $rawPhone);

        // Validation: nomor hp kurang dari 10 digit -> GAGAL ENRICH (Nomor Tidak Aktif)
        if (strlen($cPhone) < 10) {
            $profile = DcpCustomerProfile::updateOrCreate(
                ['contact_id' => $contact->id],
                [
                    'name' => $contact->name,
                    'phone_number' => $rawPhone ?: ($cPhone ?: '0812'),
                    'email' => $contact->email ?: strtolower(str_replace(' ', '.', $contact->name)) . '@company.com',
                    'job_title' => $contact->job_title ?: '-',
                    'company' => $contact->account?->name ?: '-',
                    'residential_area' => 'Unverified',
                    'city' => 'Tidak Terdaftar',
                    'gender' => 'Unknown',
                    'age' => 0,
                    'buying_power' => 'Unrated',
                    'credit_score' => 0,
                    'phone_device_type' => 'Unknown Device',
                    'competitor_product_usage' => 'Unreachable MSISDN',
                    'top_applications' => [],
                    'frequently_visited_places' => [],
                    'most_purchased_products' => [],
                    'preferred_banks' => [],
                    'payment_history' => 'Unverified',
                    'outstanding_amount' => 0.00,
                    'fraud_risk' => 'High',
                    'gambling_indicator' => false,
                    'blacklist_status' => false,
                    'phone_status' => 'Inactive',
                    'customer_consent' => false,
                    'enrichment_status' => 'Failed',
                    'tags' => ['Gagal Enrich', 'Nomor Tidak Aktif', 'Invalid MSISDN'],
                ]
            );

            return response()->json([
                'status' => 'failed_enrichment',
                'message' => "Enrichment gagal: Nomor HP '{$rawPhone}' kurang dari 10 digit. Verifikasi Telco Gateway HLR gagal (Nomor Tidak Aktif).",
                'data' => $profile,
            ]);
        }

        // Phone >= 10 digits -> Success Telco Enrichment
        $cEmail = $contact->email ?: strtolower(str_replace(' ', '.', $contact->name)) . '@company.com';
        $profile = DcpCustomerProfile::updateOrCreate(
            ['contact_id' => $contact->id],
            [
                'name' => $contact->name,
                'phone_number' => $cPhone,
                'email' => $cEmail,
                'job_title' => $contact->job_title ?: 'Senior IT Consultant',
                'company' => $contact->account?->name ?: 'PT Solusi Teknologi Nusantara',
                'residential_area' => 'High Class',
                'city' => 'Jakarta Selatan',
                'gender' => 'Male',
                'age' => 31,
                'buying_power' => 'High',
                'credit_score' => 795,
                'phone_device_type' => 'Apple iPhone 15 Pro',
                'competitor_product_usage' => 'Telco Active Postpaid',
                'top_applications' => ['BCA Mobile', 'Tokopedia', 'Strava', 'LinkedIn', 'Slack'],
                'frequently_visited_places' => ['Pacific Place / SCBD', 'Grand Indonesia', 'Senayan City'],
                'most_purchased_products' => ['Gadgets & Tech', 'Specialty Coffee', 'Airlines & Travel'],
                'preferred_banks' => ['BCA', 'Bank Mandiri'],
                'payment_history' => 'Smooth',
                'outstanding_amount' => 0.00,
                'fraud_risk' => 'Low',
                'gambling_indicator' => false,
                'blacklist_status' => false,
                'phone_status' => 'Active',
                'customer_consent' => true,
                'enrichment_status' => 'Enriched',
                'tags' => ['Tech Professional', 'High Buying Power', 'Verified Subscriber'],
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => "Contact '{$contact->name}' successfully enriched via Telco Provider Gateway!",
            'data' => $profile,
        ]);
    }

    /**
     * Apply Enrichment Filter on Contacts
     */
    public function applyFilter(Request $request): JsonResponse
    {
        $contactSource = $request->input('contact_source', 'all'); // all, enriched, manual

        $filters = [
            'gender' => $request->input('gender', 'All'),
            'age_min' => $request->filled('age_min') ? (int) $request->input('age_min') : null,
            'age_max' => $request->filled('age_max') ? (int) $request->input('age_max') : null,
            'residential_area' => $request->input('residential_area', []),
            'city' => $request->input('city', []),
            'buying_power' => $request->input('buying_power', []),
            'top_application' => $request->input('top_application', []),
            'phone_device_type' => $request->input('phone_device_type', []),
            'competitor_product' => $request->input('competitor_product', []),
            'frequently_visited_places' => $request->input('frequently_visited_places', []),
            'min_credit_score' => $request->filled('min_credit_score') ? (int) $request->input('min_credit_score') : null,
            'exclude_gambling' => $request->boolean('exclude_gambling', false),
            'exclude_blacklist' => $request->boolean('exclude_blacklist', false),
        ];

        // Format active filters for display badges
        $activeFilterBadges = [];
        if ($contactSource === 'enriched') {
            $activeFilterBadges[] = 'Source: CDP Enriched';
        } elseif ($contactSource === 'manual') {
            $activeFilterBadges[] = 'Source: Manual CRM';
        }

        if ($filters['gender'] && $filters['gender'] !== 'All') {
            $activeFilterBadges[] = 'Gender: ' . $filters['gender'];
        }
        if ($filters['age_min'] || $filters['age_max']) {
            $min = $filters['age_min'] ?? 18;
            $max = $filters['age_max'] ?? 80;
            $activeFilterBadges[] = "Age: {$min}-{$max}";
        }
        if (!empty($filters['residential_area'])) {
            $activeFilterBadges[] = 'Area: ' . implode(', ', (array) $filters['residential_area']);
        }
        if (!empty($filters['city'])) {
            $activeFilterBadges[] = 'City: ' . implode(', ', (array) $filters['city']);
        }
        if (!empty($filters['buying_power'])) {
            $activeFilterBadges[] = 'Buying Power: ' . implode(', ', (array) $filters['buying_power']);
        }
        if (!empty($filters['top_application'])) {
            $activeFilterBadges[] = 'App: ' . implode(', ', (array) $filters['top_application']);
        }
        if (!empty($filters['phone_device_type'])) {
            $activeFilterBadges[] = 'Device: ' . implode(', ', (array) $filters['phone_device_type']);
        }
        if (!empty($filters['competitor_product'])) {
            $activeFilterBadges[] = 'Competitor: ' . implode(', ', (array) $filters['competitor_product']);
        }
        if (!empty($filters['frequently_visited_places'])) {
            $activeFilterBadges[] = 'Places: ' . implode(', ', (array) $filters['frequently_visited_places']);
        }
        if ($filters['min_credit_score']) {
            $activeFilterBadges[] = 'Credit Score >= ' . $filters['min_credit_score'];
        }
        if ($filters['exclude_gambling']) {
            $activeFilterBadges[] = 'No Online Gambling';
        }
        if ($filters['exclude_blacklist']) {
            $activeFilterBadges[] = 'No Blacklist';
        }

        $allContacts = Helper::model('contact')::all();
        $matchingContactIds = [];
        $enrichedMatchingCount = 0;
        $manualMatchingCount = 0;

        if ($contactSource === 'manual') {
            // Only manual contacts
            $linkedContactIds = DcpCustomerProfile::whereNotNull('contact_id')->pluck('contact_id')->toArray();
            foreach ($allContacts as $c) {
                if (!in_array($c->id, $linkedContactIds)) {
                    $matchingContactIds[] = $c->id;
                    $manualMatchingCount++;
                }
            }
        } else {
            // Query matching profiles through IdaService
            $matchingProfiles = $this->idaService->queryAudience($filters)->get();
            $profileContactIds = $matchingProfiles->pluck('contact_id')->filter()->toArray();
            $profilePhones = $matchingProfiles->pluck('phone_number')->map(fn($p) => preg_replace('/[^0-9]/', '', $p))->filter()->toArray();
            $profileNames = $matchingProfiles->pluck('name')->map(fn($n) => strtolower(trim($n)))->toArray();

            foreach ($allContacts as $c) {
                $cPhone = preg_replace('/[^0-9]/', '', $c->primary_mobile_phone ?? $c->primary_phone ?? '');
                $cName = strtolower(trim($c->name));

                $isEnrichedMatch = in_array($c->id, $profileContactIds)
                    || ($cPhone && in_array($cPhone, $profilePhones))
                    || in_array($cName, $profileNames);

                if ($isEnrichedMatch) {
                    $matchingContactIds[] = $c->id;
                    $enrichedMatchingCount++;
                } elseif ($contactSource === 'all' && empty($activeFilterBadges)) {
                    // No specific filters, keep manual too
                    $matchingContactIds[] = $c->id;
                    $manualMatchingCount++;
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'matching_contact_ids' => array_values(array_unique($matchingContactIds)),
                'active_filter_badges' => $activeFilterBadges,
                'counts' => [
                    'total' => count($matchingContactIds),
                    'enriched' => $enrichedMatchingCount,
                    'manual' => $manualMatchingCount,
                ],
            ],
        ]);
    }

    protected function extendColumns(): array
    {
        return [
            'npwp',
            'no_ktp',
            'status_id',
            'segmentation_id',
        ];
    }
}
