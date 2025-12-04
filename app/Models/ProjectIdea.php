<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant; // CRITICAL IMPORT

class ProjectIdea extends Model
{
    use HasFactory, BelongsToTenant; // Add BelongsToTenant trait

    protected $fillable = [
        'tenant_id', 
        'team_id',
        'problem_short', // <--- CRITICAL FIX: Ye fillable mein hona chahiye
        'goal',          // <--- Ye fillable mein hona chahiye
        'description', 
        'status', 
        'pain_score', 
        'priority',
        'developer_notes',
        'cost',
        'time_duration_hours',
        'prio_1', // New field
        'prio_2', // New field
        'contact_info', // New field
        'tenant_user_id',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'pain_score' => 'integer',
        'time_duration_hours' => 'integer',
        'prio_1' => 'integer', // NEW
        'prio_2' => 'integer', // NEW
    ];
}