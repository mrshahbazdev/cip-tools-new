<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Ye optional hai
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser; // <-- 1. Import Karein
use Filament\Panel; // <-- 2. Import Karein
use Stancl\Tenancy\Database\Concerns\BelongsToTenant; // <-- New Import
// 3. 'implements FilamentUser' add karein
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, BelongsToTenant; // <-- BelongsToTenant trait use karein

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_tenant_admin' => 'boolean',
        ];
    }
    public function isTenantAdmin(): bool
    {
        return $this->is_tenant_admin;
    }
    // 4. Ye Method Add Karein (Sabse Important)
    public function canAccessPanel(Panel $panel): bool
    {
        return true; // Sabko allow kar rahe hain (Future me logic laga sakte hain)
    }
    public function isSuperAdmin(): bool
    {
        // Ab ye direct database column check karega
        return $this->is_admin;
    }
}
