<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant; // CRITICAL IMPORT

class ProjectIdea extends Model
{
    use HasFactory, BelongsToTenant; // Add BelongsToTenant trait
    protected static function boot()
    {
        parent::boot();

        // Model ke 'saving' event ko hook karein
        static::saving(function ($idea) {

            // Input values ko safety ke liye float mein convert karein
            $pain = (float) $idea->pain_score;
            $cost = (float) $idea->cost;
            $duration = (float) $idea->time_duration_hours;

            // --- 1. PRIO 1 CALCULATION (Original Formula) ---
            // PRIO 1 = (Kosten / 100) + Dauer
            if ($cost >= 0 && $duration >= 0) {
                $idea->prio_1 = ($cost / 100) + $duration;
            } else {
                $idea->prio_1 = 0;
            }

            // --- 2. PRIO 2 CALCULATION (NEW REQUESTED FORMULA) ---
            // PRIO 2 = Pain * PRIO 1
            $idea->prio_2 = $pain * $idea->prio_1;

        });
    }
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
    public function comments()
    {
        return $this->hasMany(IdeaComment::class, 'project_idea_id');
    }
    public function submitter()
{
    // Submitter is a TenantUser, linked by tenant_user_id
    return $this->belongsTo(\App\Models\TenantUser::class, 'tenant_user_id');
}
}
