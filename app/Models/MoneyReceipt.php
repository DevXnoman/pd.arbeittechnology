<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoneyReceipt extends Model
{
    protected $fillable = [
        'receipt_no',
        'receipt_date',
        'client_name',
        'client_contact',
        'client_address',
        'purpose',
        'amount_received',
        'payment_method',
        'due_balance',
        'signatory_name',
        'signatory_designation',
        'project_id',
        'notes',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'amount_received' => 'decimal:2',
        'due_balance' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
