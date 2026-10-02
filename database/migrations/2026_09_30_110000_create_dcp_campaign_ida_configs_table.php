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
        Schema::create('dcp_campaign_ida_configs', function (Blueprint $table) {
            $table->id();
            $table->uuid('wa_blast_id')->index();
            $table->json('filters')->nullable();
            $table->integer('estimated_audience')->default(15420);
            $table->integer('consent_count')->default(0);
            $table->json('consented_profile_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcp_campaign_ida_configs');
    }
};
