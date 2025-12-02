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
        Schema::table('tenant_users', function (Blueprint $table) {
            // 1. Purana, Global Unique Index delete karein
            $table->dropUnique(['email']); 

            // 2. Naya, Composite Unique Index banayein (email + tenant_id)
            // Ye ensure karega ki email sirf current tenant ke andar unique hai.
            $table->unique(['email', 'tenant_id'], 'tenant_email_unique'); 
        });
    }

    public function down(): void
    {
        Schema::table('tenant_users', function (Blueprint $table) {
            // Drop the new composite index and recreate the old (optional, for safety)
            $table->dropUnique('tenant_email_unique');
            $table->unique('email'); // Purana global unique index wapas
        });
    }
};
