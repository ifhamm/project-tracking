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
        Schema::create('breakdown_part', function (Blueprint $table) {
            $table->uuid('bdp_number')->primary();
            $table->uuid('no_iwo');
            $table->foreign('no_iwo')->references('no_iwo')->on('part');
            $table->string('bdp_name');
            $table->string('bdp_number_eqv');
            $table->integer('quantity');
            $table->string('unit');
            $table->string('op_number');
            $table->date('op_date');
            $table->string('defect')->nullable();
            $table->string('mt_number')->nullable();
            $table->integer('mt_quantity')->nullable();
            $table->date('mt_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdown_part');
    }
};
