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
        Schema::create('work_progres', function (Blueprint $table) {
            $table->uuid('id_progres')->primary();
            $table->uuid('no_iwo');
            $table->foreign('no_iwo')->references('no_iwo')->on('parts');
            $table->string('step_order');
            $table->string('step_name');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_progres');
    }
};
