<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DcpCustomerProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dcp_customer_profiles';

    protected $guarded = ['id'];

    protected $casts = [
        'social_media' => 'array',
        'frequently_visited_places' => 'array',
        'most_purchased_products' => 'array',
        'preferred_banks' => 'array',
        'top_applications' => 'array',
        'tags' => 'array',
        'gambling_indicator' => 'boolean',
        'blacklist_status' => 'boolean',
        'customer_consent' => 'boolean',
        'outstanding_amount' => 'decimal:2',
        'credit_score' => 'integer',
    ];

    /**
     * Scope for active MSISDN
     */
    public function scopeActivePhone($query)
    {
        return $query->where('phone_status', 'Active');
    }

    /**
     * Scope for enriched profiles
     */
    public function scopeEnriched($query)
    {
        return $query->where('enrichment_status', 'Enriched');
    }

    /**
     * Associated CRM contact
     */
    public function contact()
    {
        return $this->belongsTo(\Solaris\Core\Helpers\Helper::model('contact'), 'contact_id');
    }
}
