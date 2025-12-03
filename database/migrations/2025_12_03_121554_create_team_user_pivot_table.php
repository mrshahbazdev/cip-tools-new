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
        Schema::create('team_user', function (Blueprint $table) {
            // Tenant Users aur Teams ko jodne ke liye
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_user_id')->constrained('tenant_users')->onDelete('cascade');
            
            $table->primary(['team_id', 'tenant_user_id']); // Composite primary key
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_user');
    }
};
