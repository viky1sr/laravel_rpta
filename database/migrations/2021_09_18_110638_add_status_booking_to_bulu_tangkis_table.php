<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusBookingToBuluTangkisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bulu_tangkis', function (Blueprint $table) {
            $table->unsignedInteger('type_booking')->default(0);
            $table->string('lama_booking')->nullable();
            $table->date('lama_booking_date')->nullable();
        });

        Schema::table('futsals', function (Blueprint $table) {
            $table->unsignedInteger('type_booking')->default(0);
            $table->string('lama_booking')->nullable();
            $table->date('lama_booking_date')->nullable();
        });

        Schema::table('perpustakaans', function (Blueprint $table) {
            $table->unsignedInteger('type_booking')->default(0);
            $table->string('lama_booking')->nullable();
            $table->date('lama_booking_date')->nullable();
        });

        Schema::table('laktasis', function (Blueprint $table) {
            $table->unsignedInteger('type_booking')->default(0);
            $table->string('lama_booking')->nullable();
            $table->date('lama_booking_date')->nullable();
        });

        Schema::table('aulas', function (Blueprint $table) {
            $table->unsignedInteger('type_booking')->default(0);
            $table->string('lama_booking')->nullable();
            $table->date('lama_booking_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bulu_tangkis', function (Blueprint $table) {
            $table->dropColumn('type_booking');
            $table->dropColumn('lama_booking');
            $table->dropColumn('lama_booking_date');
        });

        Schema::table('futsals', function (Blueprint $table) {
            $table->dropColumn('type_booking');
            $table->dropColumn('lama_booking');
            $table->dropColumn('lama_booking_date');
        });

        Schema::table('perpustakaans', function (Blueprint $table) {
            $table->dropColumn('type_booking');
            $table->dropColumn('lama_booking');
            $table->dropColumn('lama_booking_date');
        });

        Schema::table('laktasis', function (Blueprint $table) {
            $table->dropColumn('type_booking');
            $table->dropColumn('lama_booking');
            $table->dropColumn('lama_booking_date');
        });

        Schema::table('aulas', function (Blueprint $table) {
            $table->dropColumn('type_booking');
            $table->dropColumn('lama_booking');
            $table->dropColumn('lama_booking_date');
        });
    }
}
