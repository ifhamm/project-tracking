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
            $table->dropForeign('breakdown_part_no_iwo_foreign'); 

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
            $table->dropForeign('breakdown_part_no_iwo_foreign');

            $table->foreign('no_iwo')
                ->references('no_iwo')->on('parts');
        });
    }
};
