<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'membership_plan_id',
        'billing_name',
        'billing_email',
        'billing_address',
        'total_amount',
        'payment_method',
        'status',
        'period_starts_at',
        'period_ends_at',
        'external_payment_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'period_starts_at' => 'datetime',
        'period_ends_at' => 'datetime',
    ];
    
    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
    
    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }
}