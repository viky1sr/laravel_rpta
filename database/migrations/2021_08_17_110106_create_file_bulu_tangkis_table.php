<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileBuluTangkisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_bulu_tangkis', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('bulu_tangkis_id')->default(0);
            $table->text('file_bulu_tangkis');
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
        Schema::dropIfExists('file_bulu_tangkis');
    }
}
