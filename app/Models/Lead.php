<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'client_name',
        'niche',
        'contact_number',
        'email',
        'work_scope',
        'lead_incoming_date',
        'quoted_amount',
        'sold_amount',
        'status',
        'campaign_month',
        'assigned_to',
        'note',
        'project_id',
    ];

    protected $casts = [
        'work_scope' => 'array',
        'lead_incoming_date' => 'date',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class)->latest();
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
