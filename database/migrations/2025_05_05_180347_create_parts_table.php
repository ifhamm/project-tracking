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
        Schema::create('part', function (Blueprint $table) {
            $table->uuid('no_iwo')->primary();
            $table->string('no_wbs');
            $table->date('incoming_date');
            $table->string('part_name');
            $table->string('part_number');
            $table->string('no_seri');
            $table->string('description');
            $table->uuid('id_mekanik');
            $table->foreign('id_mekanik')->references('id_mekanik')->on('akun_mekanik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part');
    }
};
