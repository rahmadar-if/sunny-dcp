<?php

namespace App\Http\Controllers\Dcp;

use App\Http\Controllers\Controller;
use App\Models\DcpCampaignIdaConfig;
use App\Models\DcpCustomerProfile;
use App\Services\Indosat\IdaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Solaris\Core\Helpers\Helper;

class IdaCampaignController extends Controller
{
    protected IdaService $idaService;

    public function __construct(IdaService $idaService)
    {
        $this->idaService = $idaService;
    }

    /**
     * Show WhatsApp campaign detail within DCP context
     */
    public function showCampaign(string $id)
    {
        $repo = new (Helper::repository('wa_blast'))(new (Helper::model('wa_blast')));
        $data = $repo->findComplete($id, []);

        $breadcrumbs = [
            ['label' => 'CDP'],
            ['label' => 'Campaign & Blasting'],
            ['label' => 'WhatsApp'],
            ['label' => $data->title]
        ];

        return view("wa-blast.page", [
            'data'        => $data,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Get IDA configuration and consented contacts for a campaign
     */
    public function getConfig(string $blastId): JsonResponse
    {
        $config = DcpCampaignIdaConfig::firstOrCreate(
            ['wa_blast_id' => $blastId],
            [
                'filters' => [
                    'gender' => 'All',
                ],
                'estimated_audience' => 1600,
                'consent_count' => 0,
                'consented_profile_ids' => [],
            ]
        );

        $consentedProfiles = [];
        if (!empty($config->consented_profile_ids)) {
            $filters = $config->filters ?? [];
            $consentedProfiles = $this->idaService->queryAudience($filters)
                ->whereIn('id', $config->consented_profile_ids)
                ->get();
            
            // Keep consent_count in sync with actual matching profiles
            $config->consent_count = $consentedProfiles->count();
            $config->consented_profile_ids = $consentedProfiles->pluck('id')->toArray();
            $config->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'config' => $config,
                'consented_profiles' => $consentedProfiles,
            ],
        ]);
    }

    /**
     * Save applied Data Enrichment filter criteria
     */
    public function applyFilter(Request $request, string $blastId): JsonResponse
    {
        $config = DcpCampaignIdaConfig::firstOrNew(['wa_blast_id' => $blastId]);

        $filters = [
            // Customer Profile Data
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'operator' => $request->input('operator', 'All'),
            'social_media' => $request->input('social_media', []),
            'job_workplace' => $request->input('job_workplace'),
            'residential_area' => $request->input('residential_area', []),
            'city' => $request->input('city', []),
            'gender' => $request->input('gender', 'All'),
            'age_min' => $request->filled('age_min') ? (int) $request->input('age_min') : 18,
            'age_max' => $request->filled('age_max') ? (int) $request->input('age_max') : 70,
            'life_phase' => $request->input('life_phase', []),
            'search_by_area' => is_array($request->input('search_by_area')) ? $request->input('search_by_area') : ($request->filled('search_by_area') ? [$request->input('search_by_area')] : []),
            'income' => $request->input('income', []),

            // Behavior Data
            'frequently_visited_places' => $request->input('frequently_visited_places', []),
            'most_purchased_products' => $request->input('most_purchased_products', []),
            'interest' => $request->input('interest', []),
            'banking_behavior' => $request->input('banking_behavior', []),
            'lifestyle' => $request->input('lifestyle', []),
            'buying_power' => $request->input('buying_power', []),
            'preferred_banks' => $request->input('preferred_banks', []),
            'top_application' => $request->input('top_application', []),
            'phone_device_type' => $request->input('phone_device_type', []),
            'competitor_product' => $request->input('competitor_product', []),

            // Eligibility Check
            'payment_history' => $request->input('payment_history', []),
            'max_outstanding' => $request->filled('max_outstanding') ? (float) $request->input('max_outstanding') : null,
            'min_credit_score' => $request->filled('min_credit_score') ? (int) $request->input('min_credit_score') : null,
            'fraud_risk' => $request->input('fraud_risk', []),
            'exclude_gambling' => $request->has('exclude_gambling') && $request->boolean('exclude_gambling'),
            'exclude_blacklist' => $request->has('exclude_blacklist') && $request->boolean('exclude_blacklist'),
            'exclude_negative_credit' => $request->has('exclude_negative_credit') && $request->boolean('exclude_negative_credit'),
            'phone_status' => $request->input('phone_status', 'Active'),
            'subscription_type' => $request->input('subscription_type', []),
        ];

        // Dynamic estimated audience count based on filters (scaled to ~1,600 target)
        $multiplier = 1420;
        if (!empty($filters['top_application'])) $multiplier += count($filters['top_application']) * 240;
        if (!empty($filters['interest'])) $multiplier += count($filters['interest']) * 190;
        if (!empty($filters['residential_area'])) $multiplier += count($filters['residential_area']) * 320;
        if (!empty($filters['city'])) $multiplier += count((array) $filters['city']) * 180;
        if (!empty($filters['search_by_area'])) $multiplier += count((array) $filters['search_by_area']) * 160;
        if (!empty($filters['income'])) $multiplier += count((array) $filters['income']) * 180;
        if (!empty($filters['competitor_product'])) $multiplier += count($filters['competitor_product']) * 210;
        if ($filters['gender'] !== 'All') $multiplier = (int) round($multiplier * 0.55);
        if ($filters['min_credit_score'] > 750) $multiplier = (int) round($multiplier * 0.65);

        $config->filters = $filters;
        $config->estimated_audience = max(120, $multiplier);

        // Prune existing consented IDs to only retain those matching the newly selected filters
        $matchingProfiles = $this->idaService->queryAudience($filters)
            ->whereIn('id', $config->consented_profile_ids ?? [])
            ->get();

        $config->consented_profile_ids = $matchingProfiles->pluck('id')->toArray();
        $config->consent_count = $matchingProfiles->count();
        $config->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Enrichment filters applied successfully',
            'data' => [
                'config' => $config,
                'consented_profiles' => $matchingProfiles,
            ],
        ]);
    }

    /**
     * Simulate customer consent response (Slide 3: Get Customer Consent)
     */
    public function simulateConsent(Request $request, string $blastId): JsonResponse
    {
        $config = DcpCampaignIdaConfig::firstOrCreate(['wa_blast_id' => $blastId]);

        // Query candidate profiles matching the saved filters strictly
        $filters = $config->filters ?? [];
        $query = $this->idaService->queryAudience($filters)->where('phone_status', 'Active');
        
        $existingIds = $config->consented_profile_ids ?? [];
        $validExistingIds = (clone $query)->whereIn('id', $existingIds)->pluck('id')->toArray();

        // Pick new matching candidates not yet consented (random batch between 15 and 20)
        $batchLimit = rand(15, 20);
        $candidates = (clone $query)->whereNotIn('id', $validExistingIds)->limit($batchLimit)->get();

        if ($candidates->isEmpty()) {
            // If all matching have been consented, take top matching batch
            $candidates = (clone $query)->limit($batchLimit)->get();
        }

        if ($candidates->isEmpty()) {
            // Fallback: If strict filters produced no matches, pick from available active profiles
            $candidates = DcpCustomerProfile::where('phone_status', 'Active')->limit($batchLimit)->get();
            if ($candidates->isEmpty()) {
                $candidates = DcpCustomerProfile::limit($batchLimit)->get();
            }
        }

        $newIds = array_values(array_unique(array_merge($validExistingIds, $candidates->pluck('id')->toArray())));
        $config->consented_profile_ids = $newIds;
        $config->consent_count = count($newIds);
        $config->save();

        $allConsented = (clone $query)->whereIn('id', $newIds)->get();
        if ($allConsented->isEmpty()) {
            $allConsented = DcpCustomerProfile::whereIn('id', $newIds)->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Simulated customer consent received via WhatsApp',
            'data' => [
                'config' => $config,
                'new_candidates' => $candidates,
                'consented_profiles' => $allConsented,
            ],
        ]);
    }

    /**
     * Remove / Reset simulated customer consents back to empty
     */
    public function resetSimulation(Request $request, string $blastId): JsonResponse
    {
        $config = DcpCampaignIdaConfig::firstOrCreate(['wa_blast_id' => $blastId]);
        $config->consented_profile_ids = [];
        $config->consent_count = 0;
        $config->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Simulated customer consent list has been reset',
            'data' => [
                'config' => $config,
                'consented_profiles' => [],
            ],
        ]);
    }

    /**
     * Push consented contacts into CRM native wa_blast_audiences
     */
    public function pushToAudience(Request $request, string $blastId): JsonResponse
    {
        $config = DcpCampaignIdaConfig::where('wa_blast_id', $blastId)->first();
        if (!$config || empty($config->consented_profile_ids)) {
            return response()->json(['status' => 'error', 'message' => 'No consented profiles found.'], 400);
        }

        $profiles = DcpCustomerProfile::whereIn('id', $config->consented_profile_ids)->get();
        $pushedCount = 0;

        $defaultContactStatusId = DB::table('contact_statuses')->orderBy('position', 'asc')->value('id') ?? 'd970ab41-c414-4820-c3ab-a2d9f842b277';

        DB::transaction(function () use ($profiles, $blastId, $defaultContactStatusId, &$pushedCount) {
            foreach ($profiles as $profile) {
                // Find or create in CRM contacts table
                $contact = DB::table('contacts')->where('primary_mobile_phone', $profile->phone_number)->first();
                if (!$contact) {
                    $contactId = (string) Str::uuid();
                    DB::table('contacts')->insert([
                        'id' => $contactId,
                        'name' => $profile->name,
                        'primary_mobile_phone' => $profile->phone_number,
                        'email' => $profile->email,
                        'job_title' => $profile->job_title,
                        'status_id' => $defaultContactStatusId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $contactId = $contact->id;
                }

                // Get Pending status UUID
                $pendingStatusId = DB::table('wa_blast_audience_statuses')->where('name', 'Pending')->value('id');

                // Check if already in wa_blast_audiences
                $exists = DB::table('wa_blast_audiences')
                    ->where('wa_blast_id', $blastId)
                    ->where('contact_id', $contactId)
                    ->exists();

                if (!$exists) {
                    DB::table('wa_blast_audiences')->insert([
                        'id' => (string) Str::uuid(),
                        'wa_blast_id' => $blastId,
                        'contact_id' => $contactId,
                        'status_id' => $pendingStatusId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $pushedCount++;
                }
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => "Successfully pushed {$pushedCount} contacts to Campaign Audience table.",
            'data' => [
                'pushed_count' => $pushedCount,
            ],
        ]);
    }
}
