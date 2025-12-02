<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser; // <-- Filament Interface
use Filament\Panel; // <-- Filament Panel class

// NOTE: BelongsToTenant trait yahan nahi chahiye, kyunki ye Central User hai.

class User extends Authenticatable implements FilamentUser // Implement Filament Access
{
    use HasFactory, Notifiable; // BelongsToTenant trait removed

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // For Super Admin
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Super Admin Flag
            // 'is_tenant_admin' cast yahan nahi chahiye
        ];
    }

    // ----------------------------------------------------
    // FINAL AUTHORIZATION METHODS
    // ----------------------------------------------------

    /**
     * Checks if the user is the Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        // Central Admin user is identified by this column
        return $this->is_admin;
    }
    
    /**
     * Filament access check.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // CRITICAL FIX: Sirf Admin panel ko access do agar is_admin TRUE hai.
        if ($panel->getId() === 'admin') {
            return $this->isSuperAdmin(); 
        }
        
        // Central users ko kisi aur panel ka access nahi hai (Tenant Panel se rok diya hai)
        return false; 
    }
}