<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dcp_customer_profiles', function (Blueprint $table) {
            $table->id();

            // Customer Profile Data (Halaman 4 & 6)
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->json('social_media')->nullable(); // e.g. {"instagram": "@runner_doni", "linkedin": "in/donisaputra"}
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->string('residential_area')->default('Middle Class'); // Low Class, Middle Class, High Class
            $table->string('city')->default('Jakarta');

            // Behavior Data (Halaman 4 & 6)
            $table->json('frequently_visited_places')->nullable(); // ["GBK Senayan", "SCBD", "Grand Indonesia"]
            $table->json('most_purchased_products')->nullable();   // ["Running Shoes", "Isotonic Drinks", "Smartwatch"]
            $table->string('buying_power')->default('Medium');     // Low, Medium, High, Ultra High
            $table->json('preferred_banks')->nullable();           // ["BCA", "Mandiri", "CIMB Niaga"]
            $table->json('top_applications')->nullable();          // ["Strava", "Tokopedia", "BCA Mobile"]
            $table->string('phone_device_type')->nullable();       // "iPhone 15 Pro", "Samsung S24 Ultra"
            $table->string('competitor_product_usage')->nullable();// "Telkomsel Halo", "XL Prioritas", "IM3 Postpaid"

            // Eligibility Check (Halaman 4 & 6)
            $table->string('payment_history')->default('Smooth');  // Smooth, On-time, Late < 30d, Late > 30d
            $table->decimal('outstanding_amount', 15, 2)->default(0);
            $table->integer('credit_score')->default(750);         // 300 - 850
            $table->string('fraud_risk')->default('Low');          // Low, Medium, High
            $table->boolean('gambling_indicator')->default(false); // Indikator Judi Online / Judol
            $table->boolean('blacklist_status')->default(false);

            // Cleansing & Enrichment Meta
            $table->string('phone_status')->default('Active');     // Active, Inactive
            $table->boolean('customer_consent')->default(true);
            $table->string('enrichment_status')->default('Enriched'); // Enriched, Pending, Cleansed
            $table->json('tags')->nullable();                      // ["Marathon Runner", "High Spender", "Fit Tech"]

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcp_customer_profiles');
    }
};
