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
        Schema::table('dcp_customer_profiles', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('email');
            $table->integer('age')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dcp_customer_profiles', function (Blueprint $table) {
            $table->dropColumn(['gender', 'age']);
        });
    }
};
