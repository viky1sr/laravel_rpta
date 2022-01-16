<?php

namespace App\Http\Controllers;

use App\Models\BuluTangkis;
use App\Models\FileBuluTangkis;
use App\Models\MasterStatus;
use App\Models\MasterWaktuBooking;
use App\Models\ReasonReject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Yajra\DataTables\DataTables;
use Auth;
use DB;

class BuluTangkisController extends Controller
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
            'title' => 'Bulutangkis',
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu'),
            'status' => MasterStatus::where('id','<>',0)->get()->pluck('status_name','status_id'),
            'users' => User::where('id','<>',0)->get()
        ];

        return view('pages.bulutangkis.index',$array);
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
        return view('pages.bulutangkis.create_or_update',$array);
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

        $check = BuluTangkis::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
            ->where('waktu_booking',$req['waktu_booking'])
            ->whereIn('status',[2,3])
            ->first();

        $checkAdmin = BuluTangkis::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
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
            $checkEvent =  $checkAdmin = BuluTangkis::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan'])->addDay(1))
                ->where('waktu_booking',$req['waktu_booking'])
                ->whereIn('status',[1,2,3])
                ->first();
            if($checkEvent !=null ){
                return response()->json([
                    'status' => 'fail',
                    'messages' => 'Waktu booking sudah terisi, please pilih waktu yang lain.'
                ],422);
            }
        } else {
            $checkEvent =  BuluTangkis::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
                ->where('waktu_booking',$req['waktu_booking'])
                ->whereIn('status',[2,3])
                ->first();
            $checkEventAdmin = BuluTangkis::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
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

            $success = BuluTangkis::firstOrCreate($input);
            if ($success) {
                $upCode = [
                    'kode_booking' => 'BT' . '-' . $success->id,
                    'hari' => Carbon::parse($success->created_at)->format('D')
                ];
                BuluTangkis::where('id', $success->id)->update($upCode);
            }

            return response()->json([
                'status' => 'ok',
                'messages' => 'Success Create Booking Lapangan Bulu Tangkis.',
                'route' => route('bulu-tangkis.show', $success->id)
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
        $array = [
            'id' => $id,
            'title' => 'Info Booking Lapangan Bulu Tangkis',
            'data' => BuluTangkis::with('info_status','is_status')->find($id),
            'file_data' => FileBuluTangkis::where('bulu_tangkis_id',$id)->first(),
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];

        return view('pages.bulutangkis.update_proses',$array);
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

    public function dataTables(Request $request) {
        if(Auth::user()->hasRole('member')) {
            $data = BuluTangkis::where('bulu_tangkis.id','<>' ,0)
                ->where('bulu_tangkis.created_by','=' ,Auth::user()->id)
                ->leftJoin('master_statuses','master_statuses.status_id','=','bulu_tangkis.status')
                ->select('bulu_tangkis.*','master_statuses.status_name');
        } else if(Auth::user()->hasRole('admin')) {
            $data = BuluTangkis::where('bulu_tangkis.id','<>' ,0)
                ->leftJoin('master_statuses','master_statuses.status_id','=','bulu_tangkis.status')
                ->leftJoin('users','users.id','=','bulu_tangkis.created_by')
                ->select('bulu_tangkis.*','master_statuses.status_name',
                    DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name'));
        }

        return DataTables::of($data)->toJson();
    }

    public function uploadFile(Request $request, $id){
        $req = $request->all();
        $check = FileBuluTangkis::where('bulu_tangkis_id', $id)->first();

        if(empty($check)) {
            $msg = [
                'file_bulu_tangkis.max' => 'File max 25mb.',
                'file_bulu_tangkis.required' => 'Please upload file pendukung.',

            ];
            $validation = Validator::make($req,[
                'file_bulu_tangkis' => 'required|max:25000'
            ],$msg);

            if($validation->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'messages' => $validation->errors()->first()
                ],422);
            } else {

                if ($request->hasFile('file_bulu_tangkis')) {
                    $file = $request->file('file_bulu_tangkis');
                    $file = $this->uploadFileBuluTangkis($file);
                    $pp =  $request->merge([
                        'file_bulu_tangkis' => $file->getFileInfo()->getFilename(),
                    ]);
                }

                $input = [
                    'bulu_tangkis_id' => $req['bulu_tangkis_id'],
                    'file_bulu_tangkis' => !empty($file) ? $file->getFileInfo()->getFilename() : null
                ];

                $success = FileBuluTangkis::firstOrCreate($input);
                if($success) {
                    $status = [
                        'status' => 2
                    ];

                    BuluTangkis::find($id)->update($status);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success upload file pendukung.'
                    ],200);
                }
            }
        } else {
            $validation = Validator::make($req,[
                'status' => 'required'
            ]);

            if($validation->fails()){
                return response()->json([
                    'status' => 'fail',
                    'messages' => 'Please select status.'
                ],422);
            } else {
                if($req['status'] != 0) {
                    $status = [
                        'status' => $req['status']
                    ];
                    BuluTangkis::find($id)->update($status);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success update booking BuluTangkis.'
                    ],200);
                } else {
                    $status = [
                        'status' => $req['status']
                    ];
                    BuluTangkis::find($id)->update($status);

                    $buluTangkis = BuluTangkis::find($id);

                    $inputReason = [
                        'model_name' => 'Bulu Tangkis',
                        'reason' => $req['reason'],
                        'kode_booking' => $buluTangkis->kode_booking
                    ];
                    ReasonReject::firstOrCreate($inputReason);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success update booking aula.'
                    ],200);
                }
            }
        }

    }

    public function uploadFileBuluTangkis(UploadedFile $file) {
        $destinationPath = public_path() . '/uploads/file_bulu_tangkis/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = $file->getClientOriginalName();
        return $file->move($destinationPath, $fileName);
    }

    public function downloadBuluTangkis($id) {
        $file = FileBuluTangkis::where('bulu_tangkis_id', $id)->firstOrFail();
        $pathToFile = public_path() . '/uploads/file_bulu_tangkis/' . $file->file_bulu_tangkis;

        return response()->download($pathToFile);
    }
}
