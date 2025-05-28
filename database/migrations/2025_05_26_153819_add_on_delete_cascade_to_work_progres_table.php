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
        Schema::table('work_progres', function (Blueprint $table) {
           
            $table->dropForeign('work_progres_no_iwo_foreign'); 

            $table->foreign('no_iwo')
                  ->references('no_iwo')->on('parts')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_progres', function (Blueprint $table) {
           
            $table->dropForeign('work_progres_no_iwo_foreign'); // <<< INI NAMA YANG BENAR!

            $table->foreign('no_iwo')
                  ->references('no_iwo')->on('parts');
        });
    }
};