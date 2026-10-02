<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Solaris\Core\Helpers\Helper;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('dcp_customer_profiles', 'contact_id')) {
            Schema::table('dcp_customer_profiles', function (Blueprint $table) {
                $table->uuid('contact_id')->nullable()->index()->after('id');
            });
        }

        // Link existing CRM contacts with dcp_customer_profiles based on phone number or name
        $contacts = Helper::model('contact')::all();
        $profiles = DB::table('dcp_customer_profiles')->get();

        foreach ($contacts as $contact) {
            $cPhone = preg_replace('/[^0-9]/', '', $contact->primary_mobile_phone ?? $contact->primary_phone ?? '');
            
            $matchingProfile = $profiles->first(function ($p) use ($cPhone, $contact) {
                $pPhone = preg_replace('/[^0-9]/', '', $p->phone_number ?? '');
                return ($cPhone && $pPhone && $cPhone === $pPhone)
                    || (strtolower(trim($contact->name)) === strtolower(trim($p->name)));
            });

            if ($matchingProfile) {
                DB::table('dcp_customer_profiles')
                    ->where('id', $matchingProfile->id)
                    ->update(['contact_id' => $contact->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('dcp_customer_profiles', 'contact_id')) {
            Schema::table('dcp_customer_profiles', function (Blueprint $table) {
                $table->dropColumn('contact_id');
            });
        }
    }
};
