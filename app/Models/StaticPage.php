<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
