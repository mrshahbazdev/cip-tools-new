<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    // Helper method to fetch value by key
    public static function getValue(string $key)
    {
        return self::where('key', $key)->value('value');
    }
}
