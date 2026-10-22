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
                    if (str_contains($c, 'Seluruh') || str_contains($c, 'All')) {
                        // Blanket nationwide/island scope - match any valid records
                        $q->orWhereNotNull('city');
                    } else {
                        $q->orWhere('city', 'ilike', '%' . $c . '%');
                    }
                }
            });
        }

        // Search by Area (Sub-City / District)
        if (!empty($input['search_by_area'])) {
            $areas = (array) $input['search_by_area'];
            $query->where(function ($q) use ($areas) {
                foreach ($areas as $area) {
                    $q->orWhere('city', 'ilike', '%' . $area . '%')
                      ->orWhere('residential_area', 'ilike', '%' . $area . '%')
                      ->orWhere('frequently_visited_places', 'ilike', '%' . $area . '%');
                }
            });
        }

        // Life Phase & Occupation (Smart Telco Mapping)
        if (!empty($input['life_phase'])) {
            $phases = (array) $input['life_phase'];
            $query->where(function ($q) use ($phases) {
                foreach ($phases as $ph) {
                    $phNorm = strtolower(trim($ph));
                    if (str_contains($phNorm, 'employee') || str_contains($phNorm, 'pekerja') || str_contains($phNorm, 'karyawan')) {
                        // Any professional/employee: has job_title or company
                        $q->orWhereNotNull('job_title')
                          ->orWhereNotNull('company')
                          ->orWhere('tags', 'ilike', '%Employee%')
                          ->orWhere('tags', 'ilike', '%Professional%')
                          ->orWhere('tags', 'ilike', '%C-Level%');
                    } elseif (str_contains($phNorm, 'higher') || str_contains($phNorm, 'kuliah') || str_contains($phNorm, 'mahasiswa')) {
                        $q->orWhere('job_title', 'ilike', '%Mahasiswa%')
                          ->orWhere('job_title', 'ilike', '%Student%')
                          ->orWhere('tags', 'ilike', '%Mahasiswa%')
                          ->orWhere('tags', 'ilike', '%Higher Education%');
                    } elseif (str_contains($phNorm, 'school') || str_contains($phNorm, 'pelajar') || str_contains($phNorm, 'sma')) {
                        $q->orWhere('job_title', 'ilike', '%Pelajar%')
                          ->orWhere('job_title', 'ilike', '%Siswa%')
                          ->orWhere('tags', 'ilike', '%Pelajar%')
                          ->orWhere('tags', 'ilike', '%Student%');
                    } else {
                        $q->orWhere('job_title', 'ilike', '%' . $ph . '%')
                          ->orWhere('tags', 'ilike', '%' . $ph . '%');
                    }
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

        // Search by Income (< 1 Juta, 1-10 Juta, 10-100 Juta, 100 Juta-1 M)
        if (!empty($input['income'])) {
            $incomes = (array) $input['income'];
            $query->where(function ($q) use ($incomes) {
                foreach ($incomes as $inc) {
                    $q->orWhere('tags', 'ilike', '%' . $inc . '%')
                      ->orWhere('buying_power', 'ilike', '%' . $inc . '%');
                }
            });
        }

        // Age Group (< 18 y.o, 18-24 y.o, 25-34 y.o, 35-50 y.o, > 50 y.o)
        if (!empty($input['age_group'])) {
            $groups = (array) $input['age_group'];
            $query->where(function ($q) use ($groups) {
                foreach ($groups as $grp) {
                    if (str_contains($grp, '< 18')) {
                        $q->orWhere('age', '<', 18);
                    } elseif (str_contains($grp, '18-24')) {
                        $q->orWhereBetween('age', [18, 24]);
                    } elseif (str_contains($grp, '25-34')) {
                        $q->orWhereBetween('age', [25, 34]);
                    } elseif (str_contains($grp, '35-50')) {
                        $q->orWhereBetween('age', [35, 50]);
                    } elseif (str_contains($grp, '> 50')) {
                        $q->orWhere('age', '>', 50);
                    }
                }
            });
        }

        // Location Based (Tier, Anchor, Type - Smart Mapping)
        if (!empty($input['location_tier'])) {
            $tiers = (array) $input['location_tier'];
            $query->where(function ($q) use ($tiers) {
                foreach ($tiers as $t) {
                    $tNorm = strtolower(trim($t));
                    if (str_contains($tNorm, 'high')) {
                        $q->orWhere('residential_area', 'ilike', '%High%')
                          ->orWhere('buying_power', 'ilike', '%High%');
                    } elseif (str_contains($tNorm, 'med')) {
                        $q->orWhere('residential_area', 'ilike', '%Middle%')
                          ->orWhere('residential_area', 'ilike', '%Med%')
                          ->orWhere('buying_power', 'ilike', '%Med%');
                    } elseif (str_contains($tNorm, 'low')) {
                        $q->orWhere('residential_area', 'ilike', '%Low%')
                          ->orWhere('buying_power', 'ilike', '%Low%');
                    } else {
                        $q->orWhere('residential_area', 'ilike', '%' . $t . '%');
                    }
                }
            });
        }
        if (!empty($input['location_anchor'])) {
            $anchors = (array) $input['location_anchor'];
            $query->where(function ($q) use ($anchors) {
                foreach ($anchors as $anc) {
                    $ancNorm = strtolower(trim($anc));
                    if (str_contains($ancNorm, 'home')) {
                        $q->orWhereNotNull('residential_area')
                          ->orWhere('tags', 'ilike', '%Home%');
                    } elseif (str_contains($ancNorm, 'work')) {
                        $q->orWhereNotNull('company')
                          ->orWhere('tags', 'ilike', '%Office%')
                          ->orWhere('tags', 'ilike', '%Work%');
                    } else {
                        $q->orWhere('tags', 'ilike', '%' . $anc . '%');
                    }
                }
            });
        }
        if (!empty($input['residential_type'])) {
            $rTypes = (array) $input['residential_type'];
            $query->where(function ($q) use ($rTypes) {
                foreach ($rTypes as $rt) {
                    $rtNorm = strtolower(trim($rt));
                    if (str_contains($rtNorm, 'housing') || str_contains($rtNorm, 'komplek')) {
                        $q->orWhere('residential_area', 'ilike', '%Class%')
                          ->orWhere('tags', 'ilike', '%Housing%')
                          ->orWhere('tags', 'ilike', '%Complex%');
                    } elseif (str_contains($rtNorm, 'industr')) {
                        $q->orWhere('tags', 'ilike', '%Industrial%')
                          ->orWhere('city', 'ilike', '%Cikarang%')
                          ->orWhere('city', 'ilike', '%Karawang%');
                    } else {
                        $q->orWhere('residential_area', 'ilike', '%' . $rt . '%')
                          ->orWhere('tags', 'ilike', '%' . $rt . '%');
                    }
                }
            });
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

        // Most Purchased Products / Interest
        if (!empty($input['most_purchased_products'])) {
            $products = (array) $input['most_purchased_products'];
            $query->where(function ($q) use ($products) {
                foreach ($products as $prod) {
                    $q->orWhere('most_purchased_products', 'ilike', '%' . $prod . '%');
                }
            });
        }

        // Search by Interest (IDA 26 Catalogue)
        if (!empty($input['interest'])) {
            $interests = (array) $input['interest'];
            $query->where(function ($q) use ($interests) {
                foreach ($interests as $item) {
                    $q->orWhere('most_purchased_products', 'ilike', '%' . $item . '%')
                      ->orWhere('tags', 'ilike', '%' . $item . '%')
                      ->orWhere('top_applications', 'ilike', '%' . $item . '%');
                }
            });
        }

        // Banking & Finance Behavior (Smart Mapping)
        if (!empty($input['banking_behavior'])) {
            $banking = (array) $input['banking_behavior'];
            $query->where(function ($q) use ($banking) {
                foreach ($banking as $b) {
                    $bNorm = strtolower(trim($b));
                    if (str_contains($bNorm, 'paylater')) {
                        $q->orWhere('tags', 'ilike', '%Paylater%')
                          ->orWhere('tags', 'ilike', '%Spender%')
                          ->orWhere('payment_history', 'ilike', '%Smooth%')
                          ->orWhere('top_applications', 'ilike', '%Shopee%')
                          ->orWhere('top_applications', 'ilike', '%Tokopedia%')
                          ->orWhere('top_applications', 'ilike', '%Gojek%')
                          ->orWhere('credit_score', '>', 600);
                    } elseif (str_contains($bNorm, 'loan') || str_contains($bNorm, 'pinjaman')) {
                        $q->orWhere('tags', 'ilike', '%Loan%')
                          ->orWhere('tags', 'ilike', '%Kredit%')
                          ->orWhere('outstanding_amount', '>', 0);
                    } elseif (str_contains($bNorm, 'bank')) {
                        $q->orWhereNotNull('preferred_banks')
                          ->orWhere('top_applications', 'ilike', '%BCA%')
                          ->orWhere('top_applications', 'ilike', '%Mandiri%')
                          ->orWhere('top_applications', 'ilike', '%BRI%')
                          ->orWhere('tags', 'ilike', '%Bank%');
                    } else {
                        $q->orWhere('preferred_banks', 'ilike', '%' . $b . '%')
                          ->orWhere('tags', 'ilike', '%' . $b . '%');
                    }
                }
            });
        }

        // Lifestyle Indicator (Smart Mapping)
        if (!empty($input['lifestyle'])) {
            $lifestyle = (array) $input['lifestyle'];
            $query->where(function ($q) use ($lifestyle) {
                foreach ($lifestyle as $l) {
                    $lNorm = strtolower(trim($l));
                    if (str_contains($lNorm, 'social')) {
                        $q->orWhereNotNull('social_media')
                          ->orWhere('top_applications', 'ilike', '%Instagram%')
                          ->orWhere('top_applications', 'ilike', '%TikTok%')
                          ->orWhere('tags', 'ilike', '%Social%');
                    } elseif (str_contains($lNorm, 'abroad') || str_contains($lNorm, 'travel')) {
                        $q->orWhere('most_purchased_products', 'ilike', '%Flight%')
                          ->orWhere('most_purchased_products', 'ilike', '%Travel%')
                          ->orWhere('top_applications', 'ilike', '%Traveloka%')
                          ->orWhere('tags', 'ilike', '%Travel%');
                    } elseif (str_contains($lNorm, 'beauty') || str_contains($lNorm, 'health')) {
                        $q->orWhere('most_purchased_products', 'ilike', '%Apparel%')
                          ->orWhere('top_applications', 'ilike', '%Strava%')
                          ->orWhere('tags', 'ilike', '%Athlete%')
                          ->orWhere('tags', 'ilike', '%Runner%');
                    } elseif (str_contains($lNorm, 'food')) {
                        $q->orWhere('frequently_visited_places', 'ilike', '%Dining%')
                          ->orWhere('frequently_visited_places', 'ilike', '%Restaurant%')
                          ->orWhere('tags', 'ilike', '%Food%');
                    } elseif (str_contains($lNorm, 'commerce') || str_contains($lNorm, 'shop')) {
                        $q->orWhere('top_applications', 'ilike', '%Tokopedia%')
                          ->orWhere('top_applications', 'ilike', '%Shopee%')
                          ->orWhere('tags', 'ilike', '%Spender%');
                    } else {
                        $q->orWhere('tags', 'ilike', '%' . $l . '%')
                          ->orWhere('frequently_visited_places', 'ilike', '%' . $l . '%');
                    }
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

        // Top Application (Smart Mapping to Telco App Categories)
        if (!empty($input['top_application'])) {
            $apps = (array) $input['top_application'];
            $query->where(function ($q) use ($apps) {
                foreach ($apps as $app) {
                    $appNorm = strtolower(trim($app));
                    if (str_contains($appNorm, 'bank')) {
                        $q->orWhere('top_applications', 'ilike', '%BCA%')
                          ->orWhere('top_applications', 'ilike', '%Mandiri%')
                          ->orWhere('top_applications', 'ilike', '%BRI%')
                          ->orWhere('top_applications', 'ilike', '%BNI%')
                          ->orWhere('top_applications', 'ilike', '%CIMB%')
                          ->orWhere('top_applications', 'ilike', '%Jenius%')
                          ->orWhere('top_applications', 'ilike', '%OCTO%')
                          ->orWhere('top_applications', 'ilike', '%Bank%')
                          ->orWhereNotNull('preferred_banks');
                    } elseif (str_contains($appNorm, 'shop') || str_contains($appNorm, 'e-commerce')) {
                        $q->orWhere('top_applications', 'ilike', '%Tokopedia%')
                          ->orWhere('top_applications', 'ilike', '%Shopee%')
                          ->orWhere('top_applications', 'ilike', '%Blibli%')
                          ->orWhere('top_applications', 'ilike', '%Lazada%')
                          ->orWhere('top_applications', 'ilike', '%TikTok%')
                          ->orWhere('top_applications', 'ilike', '%Bukalapak%');
                    } elseif (str_contains($appNorm, 'stream')) {
                        $q->orWhere('top_applications', 'ilike', '%Spotify%')
                          ->orWhere('top_applications', 'ilike', '%Netflix%')
                          ->orWhere('top_applications', 'ilike', '%YouTube%')
                          ->orWhere('top_applications', 'ilike', '%Disney%')
                          ->orWhere('top_applications', 'ilike', '%Vidio%');
                    } elseif (str_contains($appNorm, 'gam')) {
                        $q->orWhere('top_applications', 'ilike', '%Mobile Legends%')
                          ->orWhere('top_applications', 'ilike', '%PUBG%')
                          ->orWhere('top_applications', 'ilike', '%Free Fire%')
                          ->orWhere('top_applications', 'ilike', '%Steam%')
                          ->orWhere('top_applications', 'ilike', '%Game%');
                    } elseif (str_contains($appNorm, 'social') || str_contains($appNorm, 'chat')) {
                        $q->orWhere('top_applications', 'ilike', '%WhatsApp%')
                          ->orWhere('top_applications', 'ilike', '%Instagram%')
                          ->orWhere('top_applications', 'ilike', '%Telegram%')
                          ->orWhere('top_applications', 'ilike', '%Twitter%')
                          ->orWhere('top_applications', 'ilike', '%TikTok%')
                          ->orWhereNotNull('social_media');
                    } else {
                        $q->orWhere('top_applications', 'ilike', '%' . $app . '%');
                    }
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
