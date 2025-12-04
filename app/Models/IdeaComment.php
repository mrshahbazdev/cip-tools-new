<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaComment extends Model
{
    use HasFactory;
    
    protected $table = 'idea_comments'; // Assuming the table name
    
    protected $fillable = [
        'project_idea_id',
        'tenant_user_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(TenantUser::class, 'tenant_user_id');
    }
}