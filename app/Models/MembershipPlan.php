<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    // CRITICAL FIX: Add all fields that can be updated via form
    protected $fillable = [
        'name',
        'price',
        'duration_months',
        'features_list',
        'is_active', // Agar future mein use ho
    ];

    // Table name is already set implicitly but good practice to define
    // protected $table = 'membership_plans'; 
    
    // Casts for data integrity
    protected $casts = [
        'price' => 'decimal:2',
        'duration_months' => 'integer',
    ];
}
