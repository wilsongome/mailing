<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignHistory extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id','created_at', 'updated_at', 'process_data'];
}
