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
        Schema::table('project_ideas', function (Blueprint $table) {
            // Submitter ID: TenantUser model ki ID ko store karega
            $table->foreignId('tenant_user_id')->nullable()->after('team_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('project_ideas', function (Blueprint $table) {
            $table->dropForeign(['tenant_user_id']);
            $table->dropColumn('tenant_user_id');
        });
    }
};
