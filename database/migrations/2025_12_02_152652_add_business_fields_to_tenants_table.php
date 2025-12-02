<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // --- BUSINESS LOGIC FIELDS ---
            
            // 1. Bonus Payment Decision (Registration form field)
            $table->boolean('has_bonus_scheme')
                  ->default(false)
                  ->after('plan_status')
                  ->comment('Whether the project owner opts for a bonus scheme for proposers.');

            // 2. Incentive/Liability Note Text (Displayed on tenant site)
            $table->text('incentive_text')
                  ->nullable()
                  ->after('has_bonus_scheme')
                  ->comment('Remuneration text entered by Super Admin.');

            // 3. Activation Status (Manual invoice payment status)
            // 'is_active' is true only after payment is finalized.
            $table->boolean('is_active')
                  ->default(false)
                  ->after('incentive_text');

            // --- BRANDING FIELDS ---

            // 4. Custom Logo URL
            $table->string('logo_url')
                  ->nullable()
                  ->after('is_active');
                  
            // 5. Custom Slogan/Motto
            $table->string('slogan')
                  ->nullable()
                  ->after('logo_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'has_bonus_scheme',
                'incentive_text',
                'is_active',
                'logo_url',
                'slogan',
            ]);
        });
    }
};