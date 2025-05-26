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
        // Pastikan nama tabelnya 'work_progres' (dengan 'e' di akhir)
        Schema::table('work_progres', function (Blueprint $table) {
            // Drop foreign key yang lama dengan nama yang benar
            // Dari SHOW CREATE TABLE, nama FK adalah `work_progres_no_iwo_foreign`
            $table->dropForeign('work_progres_no_iwo_foreign'); // <<< INI NAMA YANG BENAR!

            // Tambahkan kembali foreign key dengan ON DELETE CASCADE
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
        // Pastikan nama tabelnya 'work_progres' (dengan 'e' di akhir)
        Schema::table('work_progres', function (Blueprint $table) {
            // Untuk rollback:
            // Drop foreign key dengan ON DELETE CASCADE menggunakan nama yang benar
            $table->dropForeign('work_progres_no_iwo_foreign'); // <<< INI NAMA YANG BENAR!

            // Tambahkan kembali foreign key tanpa ON DELETE CASCADE
            $table->foreign('no_iwo')
                  ->references('no_iwo')->on('parts');
        });
    }
};