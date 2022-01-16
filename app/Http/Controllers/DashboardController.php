<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\BuluTangkis;
use App\Models\Futsal;
use App\Models\Laktasi;
use App\Models\Perpustakaan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Yajra\DataTables\DataTables;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {


        $hari_1 =  Carbon::parse('2021-11-01')->format('D');
        $hari_2 =  Carbon::parse('2021-11-02')->format('D');
        $hari_3 =  Carbon::parse('2021-11-03')->format('D');
        $hari_4 =  Carbon::parse('2021-11-04')->format('D');
        $hari_5 =  Carbon::parse('2021-11-05')->format('D');
        $hari_6 =  Carbon::parse('2021-11-06')->format('D');
        $hari_7 =  Carbon::parse('2021-11-07')->format('D');

        $bulan_1 = Carbon::parse('2020-01-01')->format('m');
        $bulan_2 = Carbon::parse('2020-02-02')->format('m');
        $bulan_3 = Carbon::parse('2020-03-03')->format('m');
        $bulan_4 = Carbon::parse('2020-04-04')->format('m');
        $bulan_5 = Carbon::parse('2020-05-05')->format('m');
        $bulan_6 = Carbon::parse('2020-06-06')->format('m');
        $bulan_7 = Carbon::parse('2020-07-07')->format('m');
        $bulan_8 = Carbon::parse('2020-08-08')->format('m');
        $bulan_9 = Carbon::parse('2020-09-09')->format('m');
        $bulan_10 = Carbon::parse('2020-10-10')->format('m');
        $bulan_11 = Carbon::parse('2020-11-11')->format('m');
        $bulan_12 = Carbon::parse('2020-12-12')->format('m');
        $year_now = Carbon::now()->format('Y');
        $month_now = Carbon::now()->format('m');

        if($request->type_tahun == 'Hari' && $request->type_status == 'Success') {
            $lk_1 = Laktasi::where('status','=',3)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',3)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',3)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',3)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',3)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',3)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',3)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',3)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',3)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',3)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',3)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',3)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',3)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',3)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',3)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',3)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',3)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',3)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',3)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',3)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',3)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',3)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',3)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',3)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',3)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',3)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',3)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',3)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',3)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',3)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',3)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',3)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',3)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',3)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',3)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7
            ];
        } else if($request->type_tahun == 'Hari' && $request->type_status == 'On Progress') {
            $lk_1 = Laktasi::where('status','=',2)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',2)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',2)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',2)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',2)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',2)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',2)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',2)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',2)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',2)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',2)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',2)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',2)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',2)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',2)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',2)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',2)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',2)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',2)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',2)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',2)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',2)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',2)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',2)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',2)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',2)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',2)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',2)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',2)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',2)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',2)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',2)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',2)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',2)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',2)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7
            ];
        } else if($request->type_tahun == 'Hari' && $request->type_status == 'Pending') {
            $lk_1 = Laktasi::where('status','=',1)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',1)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',1)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',1)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',1)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',1)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',1)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',1)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',1)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',1)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',1)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',1)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',1)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',1)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',1)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',1)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',1)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',1)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',1)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',1)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',1)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',1)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',1)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',1)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',1)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',1)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',1)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',1)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',1)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',1)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',1)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',1)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',1)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',1)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',1)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7
            ];
        } else if($request->type_tahun == 'Hari' && $request->type_status == 'Reject') {
            $lk_1 = Laktasi::where('status','=',0)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',0)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',0)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',0)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',0)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',0)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',0)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',0)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',0)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',0)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',0)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',0)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',0)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',0)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',0)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',0)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',0)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',0)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',0)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',0)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',0)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',0)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',0)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',0)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',0)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',0)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',0)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',0)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',0)->where('hari',$hari_1)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',0)->where('hari',$hari_2)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',0)->where('hari',$hari_3)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',0)->where('hari',$hari_4)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',0)->where('hari',$hari_5)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',0)->where('hari',$hari_6)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',0)->where('hari',$hari_7)->whereMonth('created_at',$month_now)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7
            ];
        } else if($request->type_tahun == 'Bulan' && $request->type_status == 'On Progress') {
            $lk_1 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $lk_8 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $lk_9 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $lk_10 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $lk_11 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $lk_12 = Laktasi::where('status','=',2)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $pr_8 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $pr_9 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $pr_10 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $pr_11 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $pr_12 = Perpustakaan::where('status','=',2)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $ft_8 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $ft_9 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $ft_10 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $ft_11 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $ft_12 = Futsal::where('status','=',2)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $bl_8 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $bl_9 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $bl_10 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $bl_11 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $bl_12 = BuluTangkis::where('status','=',2)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $al_8 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $al_9 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $al_10 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $al_11 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $al_12 = Aula::where('status','=',2)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7,$lk_8,$lk_9,$lk_10,$lk_11,$lk_12
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7,$bl_8,$bl_9,$bl_10,$bl_11,$bl_12
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7,$ft_8,$ft_9,$ft_10,$ft_11,$ft_12
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7,$pr_8,$pr_9,$pr_10,$pr_11,$pr_12
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7,$al_8,$al_9,$al_10,$al_11,$al_12
            ];
        } else if($request->type_tahun == 'Bulan' && $request->type_status == 'Pending') {
            $lk_1 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $lk_8 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $lk_9 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $lk_10 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $lk_11 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $lk_12 = Laktasi::where('status','=',1)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $pr_8 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $pr_9 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $pr_10 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $pr_11 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $pr_12 = Perpustakaan::where('status','=',1)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $ft_8 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $ft_9 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $ft_10 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $ft_11 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $ft_12 = Futsal::where('status','=',1)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $bl_8 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $bl_9 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $bl_10 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $bl_11 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $bl_12 = BuluTangkis::where('status','=',1)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $al_8 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $al_9 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $al_10 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $al_11 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $al_12 = Aula::where('status','=',1)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7,$lk_8,$lk_9,$lk_10,$lk_11,$lk_12
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7,$bl_8,$bl_9,$bl_10,$bl_11,$bl_12
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7,$ft_8,$ft_9,$ft_10,$ft_11,$ft_12
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7,$pr_8,$pr_9,$pr_10,$pr_11,$pr_12
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7,$al_8,$al_9,$al_10,$al_11,$al_12
            ];
        } else if($request->type_tahun == 'Bulan' && $request->type_status == 'Reject') {
            $lk_1 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $lk_8 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $lk_9 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $lk_10 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $lk_11 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $lk_12 = Laktasi::where('status','=',0)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $pr_8 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $pr_9 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $pr_10 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $pr_11 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $pr_12 = Perpustakaan::where('status','=',0)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $ft_8 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $ft_9 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $ft_10 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $ft_11 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $ft_12 = Futsal::where('status','=',0)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $bl_8 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $bl_9 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $bl_10 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $bl_11 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $bl_12 = BuluTangkis::where('status','=',0)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $al_8 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $al_9 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $al_10 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $al_11 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $al_12 = Aula::where('status','=',0)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7,$lk_8,$lk_9,$lk_10,$lk_11,$lk_12
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7,$bl_8,$bl_9,$bl_10,$bl_11,$bl_12
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7,$ft_8,$ft_9,$ft_10,$ft_11,$ft_12
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7,$pr_8,$pr_9,$pr_10,$pr_11,$pr_12
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7,$al_8,$al_9,$al_10,$al_11,$al_12
            ];
        } else {
            $lk_1 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $lk_2 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $lk_3 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $lk_4 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $lk_5 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $lk_6 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $lk_7 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $lk_8 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $lk_9 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $lk_10 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $lk_11 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $lk_12 = Laktasi::where('status','=',3)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $pr_1 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $pr_2 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $pr_3 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $pr_4 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $pr_5 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $pr_6 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $pr_7 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $pr_8 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $pr_9 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $pr_10 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $pr_11 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $pr_12 = Perpustakaan::where('status','=',3)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $ft_1 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $ft_2 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $ft_3 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $ft_4 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $ft_5 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $ft_6 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $ft_7 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $ft_8 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $ft_9 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $ft_10 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $ft_11 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $ft_12 = Futsal::where('status','=',3)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $bl_1 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $bl_2 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $bl_3 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $bl_4 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $bl_5 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $bl_6 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $bl_7 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $bl_8 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $bl_9 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $bl_10 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $bl_11 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $bl_12 = BuluTangkis::where('status','=',3)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $al_1 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_1)->whereYear('created_at',$year_now)->count();
            $al_2 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_2)->whereYear('created_at',$year_now)->count();
            $al_3 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_3)->whereYear('created_at',$year_now)->count();
            $al_4 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_4)->whereYear('created_at',$year_now)->count();
            $al_5 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_5)->whereYear('created_at',$year_now)->count();
            $al_6 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_6)->whereYear('created_at',$year_now)->count();
            $al_7 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_7)->whereYear('created_at',$year_now)->count();
            $al_8 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_8)->whereYear('created_at',$year_now)->count();
            $al_9 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_9)->whereYear('created_at',$year_now)->count();
            $al_10 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_10)->whereYear('created_at',$year_now)->count();
            $al_11 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_11)->whereYear('created_at',$year_now)->count();
            $al_12 = Aula::where('status','=',3)->whereMonth('created_at',$bulan_12)->whereYear('created_at',$year_now)->count();

            $lk_name= 'Laktaksi';
            $lk_bulan = [
                $lk_1,$lk_2,$lk_3,$lk_4,$lk_5,$lk_6,$lk_7,$lk_8,$lk_9,$lk_10,$lk_11,$lk_12
            ];
            $bl_name = 'Bulutankis';
            $bl_bulan = [
                $bl_1,$bl_2,$bl_3,$bl_4,$bl_5,$bl_6,$bl_7,$bl_8,$bl_9,$bl_10,$bl_11,$bl_12
            ];
            $ft_name = 'Futsal';
            $ft_bulan = [
                $ft_1,$ft_2,$ft_3,$ft_4,$ft_5,$ft_6,$ft_7,$ft_8,$ft_9,$ft_10,$ft_11,$ft_12
            ];
            $pr_name = 'Perpustakaan';
            $pr_bulan = [
                $pr_1,$pr_2,$pr_3,$pr_4,$pr_5,$pr_6,$pr_7,$pr_8,$pr_9,$pr_10,$pr_11,$pr_12
            ];
            $al_name = 'Aula';
            $al_bulan = [
                $al_1,$al_2,$al_3,$al_4,$al_5,$al_6,$al_7,$al_8,$al_9,$al_10,$al_11,$al_12
            ];
        }

        $pr = Perpustakaan::whereDate('created_at','=',Carbon::now())
            ->select('nama_pemesan','instansi');
        $lk = Laktasi::whereDate('created_at','=',Carbon::now())
            ->select('nama_pemesan','instansi');
        $al = Aula::whereDate('created_at','=',Carbon::now())
            ->select('nama_pemesan','instansi');
        $bl = BuluTangkis::whereDate('created_at','=',Carbon::now())
            ->select('nama_pemesan','instansi');
        $ft = Futsal::whereDate('created_at','=',Carbon::now())
            ->select('nama_pemesan','instansi');

        $booking_now = $pr->unionAll($lk)->unionAll($al)->unionAll($bl)->unionAll($ft)->paginate(5);

        $is_aula = Aula::where('status','=',3)->whereYear('created_at','=',Carbon::now())->count();
        $is_per = Perpustakaan::where('status','=',3)->whereYear('created_at','=',Carbon::now())->count();
        $is_futsal = Futsal::where('status','=',3)->whereYear('created_at','=',Carbon::now())->count();
        $is_tangkis = BuluTangkis::where('status','=',3)->whereYear('created_at','=',Carbon::now())->count();
        $is_lak = Laktasi::where('status','=',3)->whereYear('created_at','=',Carbon::now())->count();

        $array = [
            'year_now' => Carbon::now()->format('Y'),
            'is_label' => $request->type_tahun ?? "Bulan",
            'type_status' => $request->type_status ?? "Success",
            'bulutangkis' => implode(",",$bl_bulan) ?? 0,
            'bulutangkis_name' => $bl_name,
            'laktaksi' => implode(",",$lk_bulan) ?? 0,
            'laktaksi_name' => $lk_name,
            'futsal' => implode(",",$ft_bulan) ?? 0,
            'futsal_name' => $ft_name,
            'aula' => implode(",",$al_bulan) ?? 0,
            'aula_name' => $al_name,
            'perpustakaan' => implode(",",$pr_bulan) ?? 0,
            'perpustakaan_name' => $pr_name,
            'booking_now' => $booking_now,
            'count_laktaksi' => $is_lak,
            'count_tangkis' => $is_tangkis,
            'count_futsal' => $is_futsal,
            'count_aula' => $is_aula,
            'count_perpustakaan' => $is_per
        ];
        return view('home',$array);
    }


    public function showAllPageBooking(){
        return view('page_bookings');
    }

    public function dataTables(Request $request){
        $pr = Perpustakaan::whereDate('perpustakaans.created_at','=',Carbon::now())
            ->leftJoin('master_statuses','master_statuses.status_id','=','perpustakaans.status')
            ->leftJoin('users','users.id','=','perpustakaans.created_by')
            ->select('perpustakaans.*','master_statuses.status_name',
                DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name')
            );
        $lk = Laktasi::whereDate('laktasis.created_at','=',Carbon::now())
            ->leftJoin('master_statuses','master_statuses.status_id','=','laktasis.status')
            ->leftJoin('users','users.id','=','laktasis.created_by')
            ->select('laktasis.*','master_statuses.status_name',
                DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name')
            );
        $al = Aula::whereDate('aulas.created_at','=',Carbon::now())
            ->leftJoin('master_statuses','master_statuses.status_id','=','aulas.status')
            ->leftJoin('users','users.id','=','aulas.created_by')
            ->select('aulas.*','master_statuses.status_name',
                DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name')
            );
        $bl = BuluTangkis::whereDate('bulu_tangkis.created_at','=',Carbon::now())
            ->leftJoin('master_statuses','master_statuses.status_id','=','bulu_tangkis.status')
            ->leftJoin('users','users.id','=','bulu_tangkis.created_by')
            ->select('bulu_tangkis.*','master_statuses.status_name',
                DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name'));
        $ft = Futsal::whereDate('futsals.created_at','=',Carbon::now())
            ->leftJoin('master_statuses','master_statuses.status_id','=','futsals.status')
            ->leftJoin('users','users.id','=','futsals.created_by')
            ->select('futsals.*','master_statuses.status_name',
                DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name'));
        $booking_now = $pr->unionAll($lk)->unionAll($al)->unionAll($bl)->unionAll($ft);

        return DataTables::of($booking_now)->toJson();
    }
}
