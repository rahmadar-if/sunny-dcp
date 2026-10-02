<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcpCampaignIdaConfig extends Model
{
    use HasFactory;

    protected $table = 'dcp_campaign_ida_configs';

    protected $guarded = ['id'];

    protected $casts = [
        'filters' => 'array',
        'consented_profile_ids' => 'array',
        'estimated_audience' => 'integer',
        'consent_count' => 'integer',
    ];
}
