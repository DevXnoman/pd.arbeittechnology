<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $fillable = [
        'project_name',
        'project_type',
        'client_name',
        'client_phone',
        'client_email',
        'project_manager',
        'start_date',
        'target_delivery_date',
        'status',
        'priority',
        'quotation_file',
        'total_cost',
        'stack_frontend',
        'stack_backend',
        'stack_database',
        'support_period',
        'support_expiry',
        'handover_checklist',
    ];

    protected $casts = [
        'handover_checklist' => 'array',
        'start_date' => 'date',
        'target_delivery_date' => 'date',
        'support_expiry' => 'date',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(ProjectTeam::class);
    }

    public function finances(): HasMany
    {
        return $this->hasMany(ProjectFinance::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ProjectRevision::class);
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(ChangeRequest::class);
    }

    public function infrastructure(): HasOne
    {
        return $this->hasOne(ProjectInfrastructure::class);
    }
}
