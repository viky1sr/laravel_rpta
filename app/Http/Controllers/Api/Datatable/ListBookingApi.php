<?php

namespace App\Http\Controllers\Api\Datatable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use Auth;

class ListBookingApi extends Controller
{
    public function pending() {
        $perustakaan = DB::table('perpustakaans')
        ->where('status','=',1);
        $aula = DB::table('aulas')
            ->where('status','=',1);
        $laktasi = DB::table('laktasis')
            ->where('status','=',1);
        $tangkis = DB::table('bulu_tangkis')
            ->where('status','=',1);
        $futsal = DB::table('futsals')
            ->where('status','=',1);

       $data = $perustakaan->unionAll($aula)->unionAll($laktasi)->unionAll($tangkis)->unionAll($futsal);

       return DataTables::of($data)->toJson();
    }

    public function onProgress() {
        $perustakaan = DB::table('perpustakaans')
            ->where('status','=',2);
        $aula = DB::table('aulas')
            ->where('status','=',2);
        $laktasi = DB::table('laktasis')
            ->where('status','=',2);
        $tangkis = DB::table('bulu_tangkis')
            ->where('status','=',2);
        $futsal = DB::table('futsals')
            ->where('status','=',2);

        $data = $perustakaan->unionAll($aula)->unionAll($laktasi)->unionAll($tangkis)->unionAll($futsal);

        return DataTables::of($data)->toJson();
    }

    public function success() {
        $perustakaan = DB::table('perpustakaans')
            ->where('status','=',3);
        $aula = DB::table('aulas')
            ->where('status','=',3);
        $laktasi = DB::table('laktasis')
            ->where('status','=',3);
        $tangkis = DB::table('bulu_tangkis')
            ->where('status','=',3);
        $futsal = DB::table('futsals')
            ->where('status','=',3);

        $data = $perustakaan->unionAll($aula)->unionAll($laktasi)->unionAll($tangkis)->unionAll($futsal);

        return DataTables::of($data)->toJson();
    }

    public function reject() {
        $perustakaan = DB::table('perpustakaans')
            ->where('status','=',0);
        $aula = DB::table('aulas')
            ->where('status','=',0);
        $laktasi = DB::table('laktasis')
            ->where('status','=',0);
        $tangkis = DB::table('bulu_tangkis')
            ->where('status','=',0);
        $futsal = DB::table('futsals')
            ->where('status','=',0);

        $data = $perustakaan->unionAll($aula)->unionAll($laktasi)->unionAll($tangkis)->unionAll($futsal);

        return DataTables::of($data)->toJson();
    }
}
