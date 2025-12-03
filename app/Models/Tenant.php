<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Contracts\TenantWithDatabase; 
use Illuminate\Database\Eloquent\Factories\HasFactory; // Ye zaroori ho sakta hai

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasFactory;

    /**
     * @var array<int, string>
     * CRITICAL: Saare naye business fields yahan shamil kiye gaye hain.
     */
    protected $fillable = [
        'id',
        'data', // JSON data field
        'trial_ends_at',
        'plan_status',
        
        // --- NEW BUSINESS FIELDS ---
        'has_bonus_scheme',
        'incentive_text',
        'is_active',
        'logo_url',
        'slogan',
    ];
    
    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'is_active' => 'boolean', // Boolean cast
        'has_bonus_scheme' => 'boolean', // Boolean cast
    ];

    /**
     * Get the columns that should be synced to the database.
     * Ye 'stancl/tenancy' ke liye zaroori hai.
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'trial_ends_at',
            'plan_status',
            
            // --- NEW BUSINESS FIELDS FOR TENANCY SYNC ---
            'has_bonus_scheme',
            'incentive_text',
            'is_active',
            'logo_url',
            'slogan',
        ];
    }
}