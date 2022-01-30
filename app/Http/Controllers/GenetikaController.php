<?php

namespace App\Http\Controllers;

use App\Models\Genetika;
use App\Models\MasterWaktuBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenetikaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        $array = [
            'title' => 'Create Booking Lapangan Futsal',
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];

        return view('pages.genetika',$array);
    }

    public function store(Request $request){
        $req = $request->all();

        $validaor = Validator::make($req,[
            'tujuan_kegiatan' => 'required',
            'no_hp' => 'required',
            'nama_pemesan' => 'required',
            'instansi' => 'required',
            'waktu_booking' => 'required',
            'tanggal_pemesanan' => 'required',
        ]);

        if($validaor->fails()){
            return response()->json([
                'status' => 'fail',
                'message' => $validaor->errors()->first()
            ],422);
        }

        $lama_booking = "";
        if($req['lama_booking_e']){
            $lama_booking = $req['lama_booking_e'];
        } elseif ($req['lama_booking_r']) {
            $lama_booking = $req['lama_booking_r'];
        }

        $input = [
            'model' => $req['model'],
            'type' => $req['type_booking'],
            'status' => 3,
            'tanggal_pemesanan' => $req['tanggal_pemesanan'],
            'waktu_booking' => $req['waktu_booking'],
            'instansi' => $req['instansi'],
            'nama_pemesan' => $req['nama_pemesan'],
            'no_hp' => $req['no_hp'],
            'lama_booking' => $lama_booking,
            'tujuan_kegiatan' => $req['tujuan_kegiatan'],
            'created_by' => \Auth::user()->id
        ];

        Genetika::firstOrCreate($input);

        return response()->json([
            'status' => 'ok',
            'message' => 'Berhasil membuat penjadwalan'.' '.$req['model'],
            'route' => route('home')
        ],201);
    }
}
