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
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('price', 8, 2)->default(0.00); // 12-month membership price
            $table->integer('duration_months')->default(12); // Always 12 months as per spec
            $table->text('features_list')->nullable(); // JSON list of features
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
