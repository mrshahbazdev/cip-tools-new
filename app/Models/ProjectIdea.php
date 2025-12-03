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
        'name', 
        'description', 
        'status', 
        'pain_score', 
        'priority',
        'developer_notes',
        'cost',
        'time_duration_hours',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'pain_score' => 'integer',
        'time_duration_hours' => 'integer',
    ];
}