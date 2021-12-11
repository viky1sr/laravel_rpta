<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\MasterWaktuBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class AulaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array = [
            'title' => 'Aula'
        ];
        return view('pages.aula.index',$array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $array = [
            'title' => 'Create Booking Aula',
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];
        return view('pages.aula.create_or_update',$array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = $request->all();

        $validation = Validator::make($req,[
            'tujuan_kegiatan' => 'required',
            'no_hp' => 'required',
            'nama_pemesan' => 'required',
            'instansi' => 'required',
            'waktu_booking' => 'required',
            'tanggal_pemesanan' => 'required',
        ]);

        $chekBooking = Carbon::parse($req['tanggal_pemesanan'])->format('d-m-y') == Carbon::now()->format('d-m-y');
        $chekTime = Carbon::parse($req['tanggal_pemesanan']) <= Carbon::now();
        if($chekBooking || $chekTime) {
            return response()->json([
                'status' => 'fail',
                'messages' => 'Tanggal pemesanan harus H-1.'
            ],422);
        }

        $check = Aula::where('tanggal_pemesanan','=',$req['tanggal_pemesanan'])
            ->where('waktu_booking',$req['waktu_booking'])
            ->whereIn('status',[2,3])
            ->first();

        $checkAdmin = Aula::where('tanggal_pemesanan','=',$req['tanggal_pemesanan'])
            ->where('waktu_booking',$req['waktu_booking'])
            ->where('status','=',1)
            ->where('created_by','=',1)
            ->first();

        if($check != null || $checkAdmin != null) {
            return response()->json([
                'status' => 'fail',
                'messages' => 'Waktu booking sudah terisi, please pilih waktu yang lain.'
            ],422);
        }

        if($req['type_booking'] == 1) {
            $checkEvent =  Aula::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan'])->addDay(1))
                ->where('waktu_booking',$req['waktu_booking'])
                ->first();
            if($checkEvent !=null ){
                return response()->json([
                    'status' => 'fail',
                    'messages' => 'Waktu booking sudah terisi, please pilih waktu yang lain.'
                ],422);
            }
        } else {
            $checkEvent  = Aula::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
                ->where('waktu_booking',$req['waktu_booking'])
                ->whereIn('status',[2,3])
                ->first();
            $checkEventAdmin = Aula::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
                ->where('waktu_booking',$req['waktu_booking'])
                ->where('status','=',1)
                ->where('created_by','=',1)
                ->first();
            if($checkEvent != null || $checkEventAdmin != null ){
                return response()->json([
                    'status' => 'fail',
                    'messages' => 'Waktu booking sudah terisi, please pilih waktu yang lain.'
                ],422);
            }
        }

        if($validation->fails()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $validation->errors()->first()
            ],422);
        } else {
            if($req['type_booking'] == 1) {
                $lama_booking = $req['lama_booking'];
                if($req['lama_booking'] == 1) {
                    $date_booking = Carbon::parse($req['tanggal_pemesanan']);
                }
                if($req['lama_booking'] == 2) {
                    $date_booking = Carbon::parse($req['tanggal_pemesanan'])->addDay(1);
                }
            }

            if($req['type_booking'] == 2) {
                $lama_booking = 0;
            }

            $input = [
                'tujuan_kegiatan' => $req['tujuan_kegiatan'],
                'no_hp' => $req['no_hp'],
                'nama_pemesan' => $req['nama_pemesan'],
                'instansi' => $req['instansi'],
                'waktu_booking' => $req['waktu_booking'],
                'tanggal_pemesanan' => $req['tanggal_pemesanan'],
                'status' => 1,
                'type_booking' => $req['type_booking'],
                'lama_booking' => $lama_booking,
                'lama_booking_date' => $date_booking ?? null,
                'created_by' => Auth::user()->id
            ];

            $success = Aula::firstOrCreate($input);
            if ($success) {
                $upCode = [
                    'kode_booking' => 'AU' . '-' . $success->id,
                ];
                Aula::where('id', $success->id)->update($upCode);
            }

            return response()->json([
                'status' => 'ok',
                'messages' => 'Success Create Booking Laktasi.',
                'route' => route('aula.show', $success->id)
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
