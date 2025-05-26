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
        Schema::table('breakdown_parts', function (Blueprint $table) {
            // Drop foreign key yang lama.
            // Nama constraint-nya adalah `breakdown_parts_no_iwo_foreign`.
            // Ini adalah nama default yang dibuat oleh Laravel.
            $table->dropForeign('breakdown_part_no_iwo_foreign'); // Hapus foreign key yang ada

            // Tambahkan kembali foreign key dengan ON DELETE CASCADE.
            // Karena `no_iwo` di kedua tabel adalah `CHAR(36)`, ini sudah pas.
            $table->foreign('no_iwo')
                ->references('no_iwo')->on('parts')
                ->onDelete('cascade'); // Ini adalah kuncinya!
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('breakdown_parts', function (Blueprint $table) {
            // Untuk rollback:
            // Hapus foreign key dengan ON DELETE CASCADE
            $table->dropForeign('breakdown_part_no_iwo_foreign');

            // Tambahkan kembali foreign key tanpa ON DELETE CASCADE (kondisi awal)
            $table->foreign('no_iwo')
                ->references('no_iwo')->on('parts');
        });
    }
};
