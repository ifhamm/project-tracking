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
        Schema::create('akun_mekanik', function (Blueprint $table) {
            $table->uuid('id_mekanik')->primary();
            $table->string('nama_mekanik');
            $table->string('username');
            $table->string('password');
            $table->string('email')->uniqiue();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_mekanik');
    }
};
