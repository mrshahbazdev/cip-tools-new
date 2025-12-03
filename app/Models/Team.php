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
        return $this->belongsToMany(TenantUser::class, 'team_user', 'team_id', 'tenant_user_id');
    }
}