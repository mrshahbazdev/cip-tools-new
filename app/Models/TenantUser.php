<?php

// app/Models/TenantUser.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Authenticatable class use karein

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Hashing automatic ho jayegi
    ];
}
