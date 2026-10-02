<?php

namespace App\Services\Indosat;

use App\Models\DcpCustomerProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IdaService
{
    /**
     * Filter customer profiles based on 3 dimensions of Indosat IDA Data
     * - Customer Profile Data
     * - Behavior Data
     * - Eligibility Check
     */
    public function queryAudience(Request|array $request): Builder
    {
        $query = DcpCustomerProfile::query();
        $input = $request instanceof Request ? $request->all() : $request;

        // ==========================================
        // 1. CUSTOMER PROFILE DATA (Slide 4 & 6)
        // ==========================================

        // Nama
        if (!empty($input['name'])) {
            $query->where('name', 'ilike', '%' . $input['name'] . '%');
        }

        // Phone Number / Keyword
        if (!empty($input['phone_number'])) {
            $query->where('phone_number', 'ilike', '%' . $input['phone_number'] . '%');
        }

        // Operator
        if (!empty($input['operator']) && $input['operator'] !== 'All') {
            $op = strtolower($input['operator']);
            $query->where(function ($q) use ($op) {
                if ($op === 'indosat' || $op === 'im3') {
                    $q->where('phone_number', 'like', '0814%')
                      ->orWhere('phone_number', 'like', '0815%')
                      ->orWhere('phone_number', 'like', '0816%')
                      ->orWhere('phone_number', 'like', '0855%')
                      ->orWhere('phone_number', 'like', '0856%')
                      ->orWhere('phone_number', 'like', '0857%')
                      ->orWhere('phone_number', 'like', '0858%')
                      ->orWhere('competitor_product_usage', 'ilike', '%indosat%')
                      ->orWhere('competitor_product_usage', 'ilike', '%im3%');
                } elseif ($op === 'telkomsel') {
                    $q->where('phone_number', 'like', '0811%')
                      ->orWhere('phone_number', 'like', '0812%')
                      ->orWhere('phone_number', 'like', '0813%')
                      ->orWhere('phone_number', 'like', '0821%')
                      ->orWhere('phone_number', 'like', '0822%')
                      ->orWhere('phone_number', 'like', '0852%')
                      ->orWhere('phone_number', 'like', '0853%')
                      ->orWhere('competitor_product_usage', 'ilike', '%telkomsel%');
                } elseif ($op === 'xl') {
                    $q->where('phone_number', 'like', '0817%')
                      ->orWhere('phone_number', 'like', '0818%')
                      ->orWhere('phone_number', 'like', '0819%')
                      ->orWhere('phone_number', 'like', '0859%')
                      ->orWhere('phone_number', 'like', '0877%')
                      ->orWhere('phone_number', 'like', '0878%')
                      ->orWhere('competitor_product_usage', 'ilike', '%xl%');
                }
            });
        }

        // Social Media
        if (!empty($input['social_media'])) {
            $socials = (array) $input['social_media'];
            $query->where(function ($q) use ($socials) {
                foreach ($socials as $s) {
                    $q->orWhere('social_media', 'ilike', '%' . $s . '%');
                }
            });
        }

        // Job & Workplace
        if (!empty($input['job_workplace'])) {
            $work = $input['job_workplace'];
            $query->where(function ($q) use ($work) {
                $q->where('job_title', 'ilike', '%' . $work . '%')
                  ->orWhere('company', 'ilike', '%' . $work . '%');
            });
        }

        // Residential Area (High Class, Middle Class, Low Class)
        if (!empty($input['residential_area'])) {
            $areas = (array) $input['residential_area'];
            $query->whereIn('residential_area', $areas);
        }

        // General: Daerah / Kota
        if (!empty($input['city'])) {
            $cities = (array) $input['city'];
            $query->where(function ($q) use ($cities) {
                foreach ($cities as $c) {
                    $q->orWhere('city', 'ilike', '%' . $c . '%');
                }
            });
        }

        // General: Gender (Male, Female)
        if (!empty($input['gender']) && $input['gender'] !== 'All') {
            $query->where('gender', $input['gender']);
        }

        // General: Range Usia (age_min, age_max)
        if (!empty($input['age_min'])) {
            $query->where('age', '>=', (int) $input['age_min']);
        }
        if (!empty($input['age_max'])) {
            $query->where('age', '<=', (int) $input['age_max']);
        }

        // ==========================================
        // 2. BEHAVIOR DATA (Slide 4 & 6)
        // ==========================================

        // Frequently Visited Places
        if (!empty($input['frequently_visited_places'])) {
            $places = (array) $input['frequently_visited_places'];
            $query->where(function ($q) use ($places) {
                foreach ($places as $place) {
                    $q->orWhere('frequently_visited_places', 'ilike', '%' . $place . '%');
                }
            });
        }

        // Most Purchased Products
        if (!empty($input['most_purchased_products'])) {
            $products = (array) $input['most_purchased_products'];
            $query->where(function ($q) use ($products) {
                foreach ($products as $prod) {
                    $q->orWhere('most_purchased_products', 'ilike', '%' . $prod . '%');
                }
            });
        }

        // Buying Power (Ultra High, High, Medium, Low)
        if (!empty($input['buying_power'])) {
            $buyingPower = (array) $input['buying_power'];
            $query->whereIn('buying_power', $buyingPower);
        }

        // Preferred Banks
        if (!empty($input['preferred_banks'])) {
            $banks = (array) $input['preferred_banks'];
            $query->where(function ($q) use ($banks) {
                foreach ($banks as $b) {
                    $q->orWhere('preferred_banks', 'ilike', '%' . $b . '%');
                }
            });
        }

        // Top Application
        if (!empty($input['top_application'])) {
            $apps = (array) $input['top_application'];
            $query->where(function ($q) use ($apps) {
                foreach ($apps as $app) {
                    $q->orWhere('top_applications', 'ilike', '%' . $app . '%');
                }
            });
        }

        // Phone & Device Type
        if (!empty($input['phone_device_type'])) {
            $devices = (array) $input['phone_device_type'];
            $query->where(function ($q) use ($devices) {
                foreach ($devices as $dev) {
                    $q->orWhere('phone_device_type', 'ilike', '%' . $dev . '%');
                }
            });
        }

        // Competitor Product Usage
        if (!empty($input['competitor_product'])) {
            $competitors = (array) $input['competitor_product'];
            $query->where(function ($q) use ($competitors) {
                foreach ($competitors as $comp) {
                    $q->orWhere('competitor_product_usage', 'ilike', '%' . $comp . '%');
                }
            });
        }

        // ==========================================
        // 3. ELIGIBILITY CHECK (Slide 4 & 6)
        // ==========================================

        // Payment History
        if (!empty($input['payment_history'])) {
            $payments = (array) $input['payment_history'];
            $query->whereIn('payment_history', $payments);
        }

        // Outstanding Amount
        if (isset($input['max_outstanding']) && $input['max_outstanding'] !== '') {
            $query->where('outstanding_amount', '<=', (float) $input['max_outstanding']);
        }

        // Min Credit Score
        if (!empty($input['min_credit_score'])) {
            $query->where('credit_score', '>=', (int) $input['min_credit_score']);
        }

        // Fraud Risk
        if (!empty($input['fraud_risk'])) {
            $risks = (array) $input['fraud_risk'];
            $query->whereIn('fraud_risk', $risks);
        }

        // Exclude Gambling Indicators
        if (!empty($input['exclude_gambling'])) {
            $query->where('gambling_indicator', false);
        }

        // Exclude Blacklist
        if (!empty($input['exclude_blacklist'])) {
            $query->where('blacklist_status', false);
        }

        // Active Phone Only
        if (!empty($input['phone_status'])) {
            $query->where('phone_status', $input['phone_status']);
        }

        return $query;
    }

    /**
     * Get aggregate statistics for the current query
     */
    public function getSummaryStats(Builder $builder): array
    {
        $profiles = (clone $builder)->get();
        $total = $profiles->count();

        $activePhoneCount = $profiles->where('phone_status', 'Active')->count();
        $marathonRunners = $profiles->filter(function ($p) {
            $tags = $p->tags ?? [];
            return in_array('Marathon Runner', $tags) || in_array('Half Marathon Finisher', $tags);
        })->count();

        $competitorUsers = $profiles->filter(function ($p) {
            return !str_contains($p->competitor_product_usage ?? '', 'Indosat') &&
                   !str_contains($p->competitor_product_usage ?? '', 'IM3');
        })->count();

        $highBuyingPower = $profiles->whereIn('buying_power', ['High', 'Ultra High'])->count();
        $cleanEligibility = $profiles->where('gambling_indicator', false)->where('blacklist_status', false)->count();

        return [
            'total_audience' => $total,
            'active_phone_count' => $activePhoneCount,
            'marathon_runners' => $marathonRunners,
            'competitor_users' => $competitorUsers,
            'high_buying_power' => $highBuyingPower,
            'clean_eligibility' => $cleanEligibility,
        ];
    }
}
