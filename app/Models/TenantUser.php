<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Models\Team; // Import the Team model
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\TenantResetPasswordNotification; // Add this

class TenantUser extends Authenticatable
{
    use HasFactory, Billable, CanResetPassword, Notifiable;

    protected $table = 'tenant_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'is_tenant_admin',
        // 'role' field is removed from fillable as it's now in pivot
        'stripe_id',
        'pm_type',
        'pm_last_four',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_tenant_admin' => 'boolean',
        'trial_ends_at' => 'timestamp',
    ];

    // --- RELATIONSHIPS ---

    public function teams()
    {
        // CRITICAL FIX: Relationship must pull the 'role' from the pivot table
        return $this->belongsToMany(Team::class, 'team_user', 'tenant_user_id', 'team_id')
                    ->withPivot('role');
    }

    // ----------------------------------------------------
    // ROLE CHECK METHODS (Updated to use Active Team Context)
    // ----------------------------------------------------

    // Helper to get the user's role in the currently active team context (from session)
    public function getCurrentTeamRoleAttribute()
    {
        $activeTeamId = session('active_team_id');
        if (!$activeTeamId) return null;

        // Pivot table mein current team ke khilaf role dhoondein
        // Note: The teams() relationship is used as a base query here
        $role = $this->teams()->where('team_id', $activeTeamId)->first()?->pivot->role;
        return $role;
    }

    public function isTenantAdmin(): bool
    {
        // This check is against the tenant_users table (Owner flag)
        return (bool) $this->is_tenant_admin;
    }

    public function isDeveloper(): bool
    {
        // CRITICAL FIX: Active team context ka role check karein
        return $this->getCurrentTeamRoleAttribute() === 'developer';
    }

    public function isWorkBee(): bool
    {
        // CRITICAL FIX: Active team context ka role check karein
        return $this->getCurrentTeamRoleAttribute() === 'work-bee';
    }

    public function getRoleNameAttribute(): string
    {
        // Role name from the active context, ya default 'Standard'
        return ucfirst($this->getCurrentTeamRoleAttribute() ?? 'Standard');
    }
    // Add this method to override the default password reset notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TenantResetPasswordNotification($token));
    }
}
