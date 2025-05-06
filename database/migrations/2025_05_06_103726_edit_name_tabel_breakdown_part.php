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
        Schema::rename('breakdown_part', 'breakdown_parts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('breakdown_parts', 'breakdown_part');
    }
};
