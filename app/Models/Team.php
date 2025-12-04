<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant; // Team is scoped to Tenant

class Team extends Model
{
    use BelongsToTenant; // Required for Stancl Scoping
    
    protected $fillable = ['tenant_id', 'name'];

    // Relationship: Team belongs to many Tenant Users
    public function members()
    {
        return $this->belongsToMany(
            TenantUser::class, 
            'team_user',           // Pivot Table Name
            'team_id',             // Foreign Key on Pivot Table (This team's ID)
            'tenant_user_id'       // Related Pivot Key (The user's ID)
        )
        ->withPivot('role');
    }
    public function developers()
    {
        return $this->members()->wherePivot('role', 'developer');
    }

    // Scoped relationship to count Work-Bee roles in this team
    public function workBees()
    {
        return $this->members()->where('role', 'work-bee');
    }
    
}