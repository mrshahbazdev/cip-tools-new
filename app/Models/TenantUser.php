<?php

// app/Models/TenantUser.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Authenticatable class use karein
use Laravel\Cashier\Billable;
class TenantUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'tenant_users'; // CRITICAL: Naya table name

    // Yahan hum Stancl ki tenanct scope use nahi karenge, kyunki ye table tenant ka hissa nahi hai
    // Har record mein khud tenant_id majood hai.

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'is_tenant_admin',
        'stripe_id', // Add new fields to fillable
        'pm_type',
        'pm_last_four',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Hashing automatic ho jayegi
        'is_tenant_admin' => 'boolean',
        'trial_ends_at' => 'timestamp',
    ];
    public function isTenantAdmin(): bool
    {
        // Ye method tenant_users table ka boolean column check karega
        // is_tenant_admin ko casts mein define karna zaroori hai.
        return (bool) $this->is_tenant_admin; 
    }
    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    public function isWorkBee(): bool
    {
        return $this->role === 'work-bee';
    }

    public function getRoleNameAttribute(): string
    {
        return ucfirst($this->role);
    }
}
