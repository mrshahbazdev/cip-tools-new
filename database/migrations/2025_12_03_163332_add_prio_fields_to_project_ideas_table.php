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
            $table->unsignedSmallInteger('prio_1')->nullable()->after('priority')->comment('Initial Priority Score');
            $table->unsignedSmallInteger('prio_2')->nullable()->after('prio_1')->comment('Secondary Priority Score');
        });
    }

    public function down(): void
    {
        Schema::table('project_ideas', function (Blueprint $table) {
            $table->dropColumn(['prio_1', 'prio_2']);
        });
    }
};
