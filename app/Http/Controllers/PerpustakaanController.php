<?php

namespace App\Http\Controllers;

use App\Models\FilePerpustakaan;
use App\Models\MasterStatus;
use App\Models\MasterWaktuBooking;
use App\Models\Perpustakaan;
use App\Models\ReasonReject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DB;

class PerpustakaanController extends Controller
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
                'title' => 'Perpustakaan',
                'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu'),
                'status' => MasterStatus::where('id','<>',0)->get()->pluck('status_name','status_id'),
                'users' => User::where('id','<>',0)->get()
            ];

            return view('pages.perpustakaan.index',$array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $array = [
            'title' => 'Create Booking Perpustakaan',
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];
        return view('pages.perpustakaan.create_or_update',$array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $length = 10)
    {
        $req = $request->all();

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

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

        $check = Perpustakaan::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
            ->where('waktu_booking',$req['waktu_booking'])
            ->whereIn('status',[2,3])
            ->first();

        $checkAdmin = Perpustakaan::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
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
            $checkEvent =  $checkAdmin = Perpustakaan::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan'])->addDay(1))
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
            $checkEvent =  Perpustakaan::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
                ->where('waktu_booking',$req['waktu_booking'])
                ->whereIn('status',[2,3])
                ->first();
            $checkEventAdmin = Perpustakaan::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
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

            $success = Perpustakaan::firstOrCreate($input);
            if($success) {
                $upCode = [
                    'kode_booking' => 'RP'.'-'.$success->id,
                    'hari' => Carbon::parse($success->created_at)->format('D')
                ];
                Perpustakaan::where('id',$success->id)->update($upCode);
            }

            return response()->json([
                'status' => 'ok',
                'messages' => 'Success Create Booking Perpustakaan.',
                'route' => route('perpustakaan.show',$success->id)
            ],200);
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
            'title' => 'Info Booking Perpustakaan',
            'id' => $id,
            'data' => Perpustakaan::with('info_status','is_status')->find($id),
            'file_data' => FilePerpustakaan::where('perpustakaan_id',$id)->first(),
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];

        return view('pages.perpustakaan.update_proses',$array);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $array = [
            'title' => 'Edit Booking Perpustakaan',
            'id' => $id,
            'data' => Perpustakaan::find($id),
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];
        return view('pages.perpustakaan.create_or_update',$array);
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
        $req = $request->all();

        $validation = Validator::make($req,[
            'tujuan_kegiatan' => 'required',
            'no_hp' => 'required',
            'nama_pemesan' => 'required',
            'instansi' => 'required',
            'end_waktu' => 'required',
            'start_waktu' => 'required',
            'tanggal_pemesanan' => 'required',
        ]);

        $checkslef = Perpustakaan::where('id',$id)
            ->where('tanggal_pemesanan','=',$req['tanggal_pemesanan'])
            ->where('waktu_booking',$req['waktu_booking'])->first();

        if($checkslef) {
            $check = Perpustakaan::where('tanggal_pemesanan','=',$req['tanggal_pemesanan'])
                ->where('waktu_booking',$req['waktu_booking'])->first();

            if($check != null) {
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
            $input = [
                'tujuan_kegiatan' => $req['tujuan_kegiatan'],
                'no_hp' => $req['no_hp'],
                'nama_pemesan' => $req['nama_pemesan'],
                'instansi' => $req['instansi'],
                'end_waktu' => $req['end_waktu'],
                'start_waktu' => $req['start_waktu'],
                'tanggal_pemesanan' => $req['tanggal_pemesanan'],
            ];

            Perpustakaan::find($id)->updated($input);

            return response()->json([
                'status' => 'ok',
                'messages' => 'Success Update Booking Perpustakaan.',
                'route' => route('perpustakaan.show',$id)
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = Perpustakaan::find($id)->delete();
        if($success) {
            return response()->json([
                'status' => 'ok',
                'messages' => 'Success deleted booking perpustakaan.'
            ],200);
        }
    }

    public function dataTables(Request $request) {
        $req = $request->all();
        if(Auth::user()->hasRole('member')) {
            $data = Perpustakaan::where('perpustakaans.id','<>' ,0)
                ->where('perpustakaans.created_by','=' ,Auth::user()->id)
                ->leftJoin('master_statuses','master_statuses.status_id','=','perpustakaans.status')
                ->select('perpustakaans.*','master_statuses.status_name');
        } else if(Auth::user()->hasRole('admin')) {
            $data = Perpustakaan::where('perpustakaans.id','<>' ,0)
                ->leftJoin('master_statuses','master_statuses.status_id','=','perpustakaans.status')
                ->leftJoin('users','users.id','=','perpustakaans.created_by')
                ->select('perpustakaans.*','master_statuses.status_name',
                    DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name')
                );
        }


        $status = $req['status'] ?? "";
        $pemesan = (!empty($req['name_pemesan']) ? $req['name_pemesan'] : "" );
        $kode_booking = (!empty($req['kode_booking']) ? $req['kode_booking'] : "" );
        $instansi = (!empty($req['instansi']) ? $req['instansi'] : "" );
        $jam_booking = (!empty($req['jam_booking']) ? $req['jam_booking'] : "" );
        $start = (!empty($req['waktu_booking_start']) ? $req['waktu_booking_start'] : "" );
        $end = (!empty($req['waktu_booking_end']) ? $req['waktu_booking_end'] : "" );
        $created_by = (!empty($req['created_by']) ? $req['created_by'] : "" );

        if($pemesan) {
            $data = $data->where('name_pemesan','LIKE','%'.$pemesan.'%');
        }
        if($pemesan) {
            $data = $data->where('instansi','LIKE','%'.$instansi.'%');
        }
        if($kode_booking) {
            $data = $data->where('kode_booking','LIKE','%'.$kode_booking.'%');
        }
        if($status != "") {
            $data = $data->where('status','=',$status);
        }
        if($created_by) {
            $data = $data->where('created_by','=',$created_by);
        }
        if($jam_booking) {
            $data = $data->where('waktu_booking','=',$jam_booking);
        }
        if($start || $end){
            $data = $data->whereDate('tanggal_pemesanan', '>=', Carbon::parse($start));
            $data = $data->whereDate('tanggal_pemesanan', '<=', Carbon::parse($end));
        }

        return DataTables::of($data)->toJson();
    }

    public function uploadFile(Request $request, $id){
        $req = $request->all();
        $check = FilePerpustakaan::where('perpustakaan_id', $id)->first();

        if(empty($check)) {
            $msg = [
                'file_perpustakaan.max' => 'File max 25mb.',
                'file_perpustakaan.required' => 'Please upload file pendukung.',

            ];
            $validation = Validator::make($req,[
                'file_perpustakaan' => 'required|max:25000'
            ],$msg);

            if($validation->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'messages' => $validation->errors()->first()
                ],422);
            } else {

                if ($request->hasFile('file_perpustakaan')) {
                    $file = $request->file('file_perpustakaan');
                    $file = $this->uploadFilePerpustakaan($file);
                    $pp =  $request->merge([
                        'file_perpustakaan' => $file->getFileInfo()->getFilename(),
                    ]);
                }

                $input = [
                    'perpustakaan_id' => $req['perpustakaan_id'],
                    'file_perpustakaan' => !empty($file) ? $file->getFileInfo()->getFilename() : null
                ];

                $success = FilePerpustakaan::firstOrCreate($input);
                if($success) {
                    $status = [
                        'status' => 2
                    ];

                    Perpustakaan::find($id)->update($status);

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
                    Perpustakaan::find($id)->update($status);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success update booking perpustakaan.'
                    ],200);
                } else {
                    $status = [
                        'status' => $req['status']
                    ];
                    Perpustakaan::find($id)->update($status);

                    $perpustakaan = Perpustakaan::find($id);

                    $inputReason = [
                        'model_name' => 'Perpustakaan',
                        'reason' => $req['reason'],
                        'kode_booking' => $perpustakaan->kode_booking
                    ];
                    ReasonReject::firstOrCreate($inputReason);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success update booking perpustakaan.'
                    ],200);
                }
            }
        }

    }

    public function uploadFilePerpustakaan(UploadedFile $file) {
        $destinationPath = public_path() . '/uploads/file_perpustakaan/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = $file->getClientOriginalName();
        return $file->move($destinationPath, $fileName);
    }

    public function downloadPerpustakaan($id) {
        $file = FilePerpustakaan::where('perpustakaan_id', $id)->firstOrFail();
        $pathToFile = public_path() . '/uploads/file_perpustakaan/' . $file->file_perpustakaan;

        return response()->download($pathToFile);
    }
}
