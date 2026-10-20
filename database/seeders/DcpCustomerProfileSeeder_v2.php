<?php

namespace Database\Seeders;

use App\Models\DcpCustomerProfile;
use Illuminate\Database\Seeder;

class DcpCustomerProfileSeeder_v2 extends Seeder
{
    /**
     * Run the database seeds for Extended / Demo Profiles.
     */
    public function run(): void
    {
        // 1. Ensure existing basic profiles have gender and age
        $existingProfiles = DcpCustomerProfile::all();
        foreach ($existingProfiles as $p) {
            $updated = false;
            if (!$p->gender) {
                $isFemale = preg_match('/\b(erica|nadia|maya|salsabila|fitri|dewi|citra|putri)\b/i', $p->name);
                $p->gender = $isFemale ? 'Female' : 'Male';
                $updated = true;
            }
            if (!$p->age) {
                $p->age = rand(28, 48);
                $updated = true;
            }
            if ($updated) {
                $p->save();
            }
        }

        // 2. Generate ~220 realistic additional profiles focused on Jakarta & Age >= 25
        $maleFirstNames = [
            'Aditya', 'Budi', 'Bayu', 'Dimas', 'Eko', 'Fajar', 'Gilang', 'Hendra', 'Ilham', 'Joko',
            'Kurniawan', 'Lukman', 'Mahendra', 'Niko', 'Oki', 'Prasetyo', 'Raditya', 'Rian', 'Rizky',
            'Satria', 'Tri', 'Wahyu', 'Yoga', 'Zulham', 'Agus', 'Bambang', 'Dedi', 'Farhan', 'Galih',
            'Haris', 'Irfan', 'Kevin', 'Mario', 'Pandu', 'Reza', 'Teguh', 'Vicky', 'Yusuf', 'Arief', 'Bagus'
        ];

        $femaleFirstNames = [
            'Amanda', 'Anisa', 'Bella', 'Citra', 'Dewi', 'Dian', 'Fitri', 'Gita', 'Hana', 'Indah',
            'Kartika', 'Lestari', 'Maya', 'Nadia', 'Putri', 'Ratna', 'Rina', 'Sari', 'Siti', 'Tania',
            'Utami', 'Vina', 'Wulan', 'Yulia', 'Zahra', 'Anggun', 'Clarissa', 'Dhea', 'Fadhilah', 'Intan',
            'Melisa', 'Natasha', 'Rania', 'Sherly', 'Tiara', 'Widya', 'Yolanda', 'Ayu', 'Nabila', 'Pratiwi'
        ];

        $lastNames = [
            'Pratama', 'Saputra', 'Wijaya', 'Kusuma', 'Santoso', 'Gunawan', 'Setiawan', 'Nugroho', 'Wibowo',
            'Hidayat', 'Siregar', 'Nasution', 'Lubis', 'Simanjuntak', 'Sitompul', 'Hutapea', 'Ginting', 'Sitorus',
            'Pasaribu', 'Manurung', 'Tanjung', 'Chaniago', 'Koto', 'Piliang', 'Suhendra', 'Hartanto', 'Suryanto',
            'Purnama', 'Darmawan', 'Utomo', 'Firmansyah', 'Wardhana', 'Sutanto', 'Halim', 'Tanujaya', 'Widjaja',
            'Susanto', 'Lie', 'Anggoro', 'Pamungkas'
        ];

        $managerJobs = [
            'Marketing Manager', 'Operations Manager', 'Sales Manager', 'Branch Manager', 'Product Manager',
            'Finance Manager', 'HR Manager', 'IT Project Manager', 'Account Manager', 'Business Development Manager',
            'Regional Manager', 'General Manager', 'Digital Marketing Manager', 'Brand Manager', 'Relationship Manager',
            'Senior Product Manager', 'Engineering Manager', 'Senior Portfolio Manager', 'Commercial Manager', 'Supply Chain Manager'
        ];

        $otherJobs = [
            'VP of Operations', 'Director of Growth', 'Head of Business Development', 'Chief Technology Officer',
            'Creative Director', 'Senior Data Consultant', 'Financial Analyst', 'Senior Software Engineer',
            'Principal Architect', 'Senior Legal Counsel', 'Investment Banker', 'Managing Partner'
        ];

        $companies = [
            'Bank Central Asia (BCA)', 'PT Bank Mandiri', 'PT Telkom Indonesia', 'PT Indosat Ooredoo Hutchison',
            'PT XL Axiata', 'GoTo Group', 'PT Astra International', 'PT Unilever Indonesia', 'Shopee Indonesia',
            'Traveloka', 'Tokopedia', 'Blibli.com', 'Sinar Mas Group', 'PT Kalbe Farma', 'PT Bank Rakyat Indonesia',
            'PT HM Sampoerna', 'Maybank Indonesia', 'CIMB Niaga', 'Djarum Group', 'Indofood Sukses Makmur',
            'Danone Indonesia', 'Grab Indonesia', 'Tiket.com', 'Kawan Lama Group', 'MAP Group'
        ];

        $jakartaDistricts = [
            'Jakarta Selatan', 'Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara',
            'Jakarta Selatan', 'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Pusat', 'Jakarta Barat'
        ];

        $otherCities = ['Tangerang Selatan', 'Bekasi', 'Depok', 'Bandung', 'Surabaya'];

        $placesPool = [
            'Pacific Place', 'Senayan City', 'Grand Indonesia', 'Plaza Indonesia', 'Central Park Jakarta',
            'PIM 3 Pondok Indah', 'Kota Kasablanka', 'Gandaria City', 'SCBD Park', 'GBK Senayan',
            'Senayan Golf Club', 'PIK Avenue', 'Mall Kelapa Gading', 'The Breeze BSD'
        ];

        $productsPool = [
            'Running Shoes', 'Garmin Forerunner', 'Isotonic Drinks', 'Smartwatch', 'Fine Dining',
            'Business Flights', 'Golf Apparel', 'Organic Supplements', 'Home Office Setup', 'Energy Chews'
        ];

        $banksPool = ['BCA', 'Bank Mandiri', 'BCA Prioritas', 'CIMB Niaga', 'Bank BNI', 'Bank Danamon', 'HSBC', 'Permata Bank'];
        $appsPool = ['BCA Mobile', 'Mandiri Livin', 'Strava', 'Tokopedia', 'Shopee', 'Grab', 'Gojek', 'MyIM3', 'Traveloka', 'Spotify', 'LinkedIn', 'Stockbit'];
        $devicesPool = ['iPhone 15 Pro Max', 'iPhone 15 Pro', 'iPhone 15', 'iPhone 14 Pro', 'Samsung Galaxy S24 Ultra', 'Samsung Galaxy S23', 'Samsung Z Fold 5', 'Google Pixel 8 Pro'];
        $competitorsPool = ['IM3 Platinum (Indosat)', 'IM3 Postpaid', 'Telkomsel Halo', 'XL Prioritas', 'IM3 Prime (Indosat)', 'Telkomsel Prepaid'];

        $prefixes = ['0815', '0816', '0857', '0858', '0812', '0813', '0878'];

        for ($i = 101; $i <= 320; $i++) {
            $isFemale = ($i % 2 === 0);
            $firstName = $isFemale ? $femaleFirstNames[array_rand($femaleFirstNames)] : $maleFirstNames[array_rand($maleFirstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            $gender = $isFemale ? 'Female' : 'Male';
            $age = rand(26, 52); // Age range ensures >= 25 match

            // 75% Jakarta, 25% surrounding
            $city = ($i % 4 !== 0)
                ? $jakartaDistricts[array_rand($jakartaDistricts)]
                : $otherCities[array_rand($otherCities)];

            // 70% Manager jobs for demo filter match, 30% other executive
            $jobTitle = ($i % 10 <= 6)
                ? $managerJobs[array_rand($managerJobs)]
                : $otherJobs[array_rand($otherJobs)];

            $company = $companies[array_rand($companies)];
            $prefix = $prefixes[array_rand($prefixes)];
            $phone = $prefix . sprintf('%07d', 1000000 + $i * 7);

            $cleanName = strtolower(str_replace(' ', '.', $name));
            $email = $cleanName . '@' . strtolower(explode(' ', str_replace(['(', ')', '.', 'PT '], '', $company))[0]) . '.com';

            $userPlaces = (array) array_rand(array_flip($placesPool), rand(2, 4));
            $userProducts = (array) array_rand(array_flip($productsPool), rand(2, 3));
            $userBanks = (array) array_rand(array_flip($banksPool), rand(1, 2));
            $userApps = (array) array_rand(array_flip($appsPool), rand(3, 5));

            DcpCustomerProfile::updateOrCreate(
                ['phone_number' => $phone],
                [
                    'name' => $name,
                    'phone_number' => $phone,
                    'email' => $email,
                    'gender' => $gender,
                    'age' => $age,
                    'job_title' => $jobTitle,
                    'company' => $company,
                    'residential_area' => ($i % 3 === 0) ? 'Middle Class' : 'High Class',
                    'city' => $city,
                    'social_media' => [
                        'instagram' => '@' . str_replace('.', '_', $cleanName),
                        'linkedin' => 'in/' . str_replace('.', '-', $cleanName)
                    ],
                    'frequently_visited_places' => array_values($userPlaces),
                    'most_purchased_products' => array_values($userProducts),
                    'buying_power' => ($i % 4 === 0) ? 'Ultra High' : 'High',
                    'preferred_banks' => array_values($userBanks),
                    'top_applications' => array_values($userApps),
                    'phone_device_type' => $devicesPool[array_rand($devicesPool)],
                    'competitor_product_usage' => $competitorsPool[array_rand($competitorsPool)],
                    'payment_history' => 'Smooth',
                    'outstanding_amount' => rand(0, 3) * 500000,
                    'credit_score' => rand(720, 850),
                    'fraud_risk' => 'Low',
                    'gambling_indicator' => false,
                    'blacklist_status' => false,
                    'phone_status' => 'Active',
                    'enrichment_status' => 'Enriched',
                    'tags' => ['Active Professional', 'Jakarta Audience', 'Consented Target'],
                ]
            );
        }
    }
}
