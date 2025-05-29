<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumentasiMekaniksTable extends Migration
{
    public function up()
    {
        Schema::create('dokumentasi_mekaniks', function (Blueprint $table) {
            $table->id();
            $table->uuid('no_iwo');
            $table->string('no_wbs');
            $table->string('komponen');
            $table->string('step_name');
            $table->date('tanggal');
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumentasi_mekaniks');
    }
}
