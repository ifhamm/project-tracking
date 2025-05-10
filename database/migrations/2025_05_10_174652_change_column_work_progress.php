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
        schema::table('work_progres', function (Blueprint $table) {
            $table->renameColumn('is_complete', 'is_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('work_progres', function (Blueprint $table) {
            $table->renameColumn('is_completed', 'is_complete');
        });
    }
};
