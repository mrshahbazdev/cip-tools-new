<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains; // Ye line check karein

class Tenant extends BaseTenant
{
    use HasDatabase, HasDomains; // Ye line SABSE important hai

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'trial_ends_at',
            'plan_status',
        ];
    }
}
