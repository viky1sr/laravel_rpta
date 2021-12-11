<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpustakaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpustakaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->default(0);
            $table->string('status')->default(0);
            $table->date('tanggal_pemesanan');
            $table->string('waktu_booking');
            $table->string('instansi');
            $table->string('nama_pemesan');
            $table->string('no_hp');
            $table->string('hari')->nullable();
            $table->text('tujuan_kegiatan');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perpustakaans');
    }
}
