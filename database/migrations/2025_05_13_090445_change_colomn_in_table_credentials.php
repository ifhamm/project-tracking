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
        Schema::table('credentials', function (Blueprint $table) {
            $table->renameColumn('id_mekanik', 'id_credentials')->change();
            $table->renameColumn('nama_mekanik', 'name')->change();
            $table->dropColumn('username');
            $table->string('nik')->unique()->nullable();
            $table->string('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credentials', function (Blueprint $table) {
            $table->renameColumn('id_credentials', 'id_mekanik')->change();
            $table->renameColumn('name', 'nama_mekanik')->change();
            $table->string('username')->unique()->nullable();
            $table->dropColumn('nik');
            $table->dropColumn('role');
        });
    }
};
