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
        Schema::create('project_ideas', function (Blueprint $table) {
            $table->id();
            
            // 1. TENANCY SCOPE (CRITICAL)
            $table->string('tenant_id', 255)->index(); // Links the idea to its owner project
            
            // 2. IDEA & DESCRIPTION
            $table->string('name'); 
            $table->text('description');

            // 3. WORKFLOW STATUS
            $table->string('status')->default('New')->index(); // e.g., New, Reviewed, Approved, Done
            
            // 4. WORK-BEE FIELDS (Editable by Work-Bees/Admins)
            $table->unsignedTinyInteger('pain_score')->nullable()->comment('Schmerz score (1-10)');
            $table->unsignedTinyInteger('priority')->nullable()->comment('Final Priority Score (Umsetzung)');
            
            // 5. DEVELOPER FIELDS (Editable by Dev/Admins)
            $table->text('developer_notes')->nullable()->comment('Lösung details and implementation notes');
            $table->decimal('cost', 8, 2)->nullable()->comment('Kosten (Development Cost)');
            $table->integer('time_duration_hours')->nullable()->comment('Dauer (Implementation time in hours)');

            $table->timestamps();
            
            // Optional: Foreign key constraint for integrity
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_ideas');
    }
};
