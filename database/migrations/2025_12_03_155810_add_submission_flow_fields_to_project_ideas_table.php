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
            // Renaming 'name' to 'problem_short' and adding 'goal' and 'contact_info'
            $table->renameColumn('name', 'problem_short'); // Rename existing 'name' field
            $table->text('goal')->nullable()->after('problem_short');
            $table->string('contact_info')->nullable()->after('priority');
        });
    }

    public function down(): void
    {
        Schema::table('project_ideas', function (Blueprint $table) {
            $table->dropColumn(['goal', 'contact_info']);
            $table->renameColumn('problem_short', 'name');
        });
    }
};
