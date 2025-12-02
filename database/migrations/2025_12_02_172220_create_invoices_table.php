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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            
            // --- CORE TENANCY & MEMBERSHIP ---
            $table->string('tenant_id')->index();
            $table->foreignId('membership_plan_id')->nullable()->constrained()->onDelete('set null');

            // --- BILLING DETAILS ---
            $table->string('billing_name');
            $table->string('billing_email');
            $table->text('billing_address'); // Full address for invoicing
            
            // --- PAYMENT & STATUS ---
            $table->decimal('total_amount', 8, 2);
            $table->string('payment_method')->comment('Card, PayPal, or Invoice');
            $table->string('status')->default('pending')->comment('paid, pending, failed, cancelled');

            // --- SUBSCRIPTION PERIOD ---
            $table->timestamp('period_starts_at')->nullable();
            $table->timestamp('period_ends_at')->nullable();

            // --- EXTERNAL REFERENCES (Cashier/PayPal) ---
            $table->string('external_payment_id')->nullable()->unique(); // Stripe/PayPal Reference ID
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
