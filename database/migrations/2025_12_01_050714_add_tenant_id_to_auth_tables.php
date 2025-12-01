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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tenant_id')->nullable()->index();
        });

        // Sessions table mein bhi add karein
        Schema::table('sessions', function (Blueprint $table) {
            $table->string('tenant_id')->nullable()->index();
        });

        // Agar future mein koi aur table ho (e.g., projects), wahan bhi add hoga
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
        });
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
        });
    }
};
