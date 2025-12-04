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
            // Check if column exists before dropping (for safety)
            if (Schema::hasColumn('tenant_users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add the role column (only for rollback safety, though not the desired end state)
        Schema::table('tenant_users', function (Blueprint $table) {
            $table->string('role')->default('work-bee')->after('is_tenant_admin');
        });
    }
};
