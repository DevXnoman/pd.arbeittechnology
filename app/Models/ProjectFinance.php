<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFinance extends Model
{
    protected $fillable = [
        'project_id',
        'quotation_file_name',
        'total_cost',
        'milestone_name',
        'amount',
        'date_paid',
        'status',
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'date_paid' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
