<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenetikasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genetikas', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('type');
            $table->unsignedBigInteger('total_runing')->default(0);
            $table->string('kode_booking')->default(0);
            $table->string('status')->default(0);
            $table->date('tanggal_pemesanan');
            $table->string('waktu_booking');
            $table->string('instansi');
            $table->string('nama_pemesan');
            $table->string('no_hp');
            $table->string('lama_booking')->nullable();
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
        Schema::dropIfExists('genetikas');
    }
}
