<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SetupWizard extends Component
{
    // Form Inputs
    public $appUrl;
    public $dbHost = 'localhost';
    public $dbDatabase;
    public $dbUsername;
    public $dbPassword;
    public $centralDomain; // For Tenancy config

    protected $rules = [
        'appUrl' => 'required|url',
        'dbDatabase' => 'required|string',
        'dbUsername' => 'required|string',
        'centralDomain' => 'required|string',
    ];

    public function mount()
    {
        // Default values ko .env se load karein (agar exist karta hai)
        $this->appUrl = env('APP_URL', 'http://localhost');
        $this->dbDatabase = env('DB_DATABASE', '');
        $this->dbUsername = env('DB_USERNAME', '');
        $this->centralDomain = env('TENANCY_CENTRAL_DOMAIN', 'cip-tools.de');
    }

    public function submitSetup()
    {
        $this->validate();

        // 1. .ENV File Update Logic (CRITICAL)
        $path = base_path('.env');

        if (file_exists($path)) {
            // Existing .env content load karein
            $content = File::get($path);

            $replacements = [
                'APP_URL' => $this->appUrl,
                'DB_HOST' => $this->dbHost,
                'DB_DATABASE' => $this->dbDatabase,
                'DB_USERNAME' => $this->dbUsername,
                'DB_PASSWORD' => $this->dbPassword,
                'TENANCY_CENTRAL_DOMAIN' => $this->centralDomain,
            ];

            foreach ($replacements as $key => $value) {
                // Ensure the value is sanitized and formatted correctly
                $value = (is_null($value) || $value === '') ? 'null' : $value;
                $content = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $content);
            }

            File::put($path, $content);
        }

        // 2. Clear Config Cache (Configuration ko refresh karein)
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        // 3. Database Migration Run Karein (Artisan via PHP)
        try {
            Artisan::call('migrate --force');
            Artisan::call('tenants:migrate'); // Stancl Tenancy Migrations
            session()->flash('success', 'Setup complete! Database migrated successfully.');

            // 4. Final Redirect
            return redirect('/');
        } catch (\Exception $e) {
            session()->flash('error', 'Database setup failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.setup-wizard')->layout('components.layouts.guest');
    }
}
