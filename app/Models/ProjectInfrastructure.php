<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectInfrastructure extends Model
{
    protected $fillable = [
        'project_id',
        'domain_url',
        'domain_provider',
        'domain_user',
        'domain_pass',
        'hosting_provider',
        'hosting_user',
        'hosting_pass',
        'server_ip',
        'panel_url',
        'extra_credentials',
    ];

    protected $casts = [
        'extra_credentials' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
