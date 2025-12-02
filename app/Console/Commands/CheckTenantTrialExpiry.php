<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\User; // To find the admin user
use App\Notifications\TrialExpiryAlert;
use Illuminate\Support\Facades\Notification;

class CheckTenantTrialExpiry extends Command
{
    protected $signature = 'tenant:check-expiry';
    protected $description = 'Checks tenant trial expiry dates and sends notifications at 20, 25, and 30 days.';

    public function handle()
    {
        $alertDays = [30, 25, 20, 10, 5, 1]; // Days when alerts should be sent

        // Fetch all tenants whose plan is not active
        $tenantsToNotify = Tenant::where('plan_status', 'trial')
            ->whereNotNull('trial_ends_at')
            ->get();

        $this->info("Checking " . $tenantsToNotify->count() . " trial accounts...");

        foreach ($tenantsToNotify as $tenant) {
            $daysLeft = now()->diffInDays($tenant->trial_ends_at, false);

            if (in_array($daysLeft, $alertDays)) {
                // Find a central user (Super Admin) to receive the notification
                $superAdmin = User::where('is_admin', true)->first(); 
                
                if ($superAdmin) {
                    Notification::send($superAdmin, new TrialExpiryAlert($tenant, $daysLeft));
                    $this->info("Notification sent to admin for tenant {$tenant->id} ({$daysLeft} days left).");
                }
            }
        }

        $this->info("Trial check completed.");
        return 0;
    }
}