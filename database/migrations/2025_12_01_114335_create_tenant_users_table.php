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
        Schema::create('tenant_users', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id', 255)->index(); // Tenant ID yahan save hoga
            $table->string('name');
            $table->string('email')->unique(); // Tenant mein email unique ho
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_tenant_admin')->default(false);
            $table->rememberToken();
            $table->timestamps();

            // Ye constraint zaroori nahi, lekin better hai
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_users');
    }
};
