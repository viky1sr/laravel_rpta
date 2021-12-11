<?php

namespace App\Http\Controllers;

use App\Models\FileFutsal;
use App\Models\Futsal;
use App\Models\MasterStatus;
use App\Models\MasterWaktuBooking;
use App\Models\ReasonReject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Yajra\DataTables\DataTables;
use Auth;
use DB;

class FutsalController extends Controller
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

        return view('pages.futsal.index',$array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $array = [
            'title' => 'Create Booking Lapangan Futsal',
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];
        return view('pages.futsal.create_or_update',$array);
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

        $check = Futsal::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
            ->where('waktu_booking',$req['waktu_booking'])
            ->whereIn('status',[2,3])
            ->first();

        $checkAdmin = Futsal::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
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
            $checkEvent =  $checkAdmin = Futsal::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan'])->addDay(1))
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
            $checkEvent =  Futsal::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
                ->where('waktu_booking',$req['waktu_booking'])
                ->whereIn('status',[2,3])
                ->first();
            $checkEventAdmin = Futsal::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan']))
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

            $success = Futsal::firstOrCreate($input);
            if ($success) {
                $upCode = [
                    'kode_booking' => 'LF' . '-' . $success->id,
                    'hari' => Carbon::parse($success->created_at)->format('D')
                ];
                Futsal::where('id', $success->id)->update($upCode);
            }

            return response()->json([
                'status' => 'ok',
                'messages' => 'Success Create Booking Lapangan Futsal.',
                'route' => route('futsal.show', $success->id)
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
            'title' => 'Info Booking Lapangan Futsal',
            'data' => Futsal::with('info_status','is_status')->find($id),
            'file_data' => FileFutsal::where('futsal_id',$id)->first(),
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];
//        dd($array['data']['status']);
        return view('pages.futsal.show',$array);
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
            'title' => 'Edit Booking Lapangan Futsal',
            'id' => $id,
            'data' => Futsal::find($id),
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];
        return view('pages.futsal.create-or-update',$array);
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
            $data = Futsal::where('futsals.id','<>' ,0)
                ->where('futsals.created_by','=' ,Auth::user()->id)
                ->leftJoin('master_statuses','master_statuses.status_id','=','futsals.status')
                ->select('futsals.*','master_statuses.status_name');
        } else if(Auth::user()->hasRole('admin')) {
            $data = Futsal::where('futsals.id','<>' ,0)
                ->leftJoin('master_statuses','master_statuses.status_id','=','futsals.status')
                ->leftJoin('users','users.id','=','futsals.created_by')
                ->select('futsals.*','master_statuses.status_name',
                    DB::raw('CONCAT(users.first_name, \' \', users.last_name) as full_name'));
        }

        return DataTables::of($data)->toJson();
    }

    public function uploadFile(Request $request, $id){
        $req = $request->all();
        $check = FileFutsal::where('futsal_id', $id)->first();

        if(empty($check)) {
            $msg = [
                'file_futsal.max' => 'File max 25mb.',
                'file_futsal.required' => 'Please upload file pendukung.',

            ];
            $validation = Validator::make($req,[
                'file_futsal' => 'required|max:25000'
            ],$msg);

            if($validation->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'messages' => $validation->errors()->first()
                ],422);
            } else {

                if ($request->hasFile('file_futsal')) {
                    $file = $request->file('file_futsal');
                    $file = $this->uploadFileBuluTangkis($file);
                    $pp =  $request->merge([
                        'file_futsal' => $file->getFileInfo()->getFilename(),
                    ]);
                }

                $input = [
                    'futsal_id' => $req['futsal_id'],
                    'file_futsal' => !empty($file) ? $file->getFileInfo()->getFilename() : null
                ];

                $success = FileFutsal::firstOrCreate($input);
                if($success) {
                    $status = [
                        'status' => 2
                    ];

                    Futsal::find($id)->update($status);

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
                    Futsal::find($id)->update($status);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success update booking lapangan futsal.'
                    ],200);
                } else {
                    $status = [
                        'status' => $req['status']
                    ];
                    Futsal::find($id)->update($status);

                    $futsal = Futsal::find($id);

                    $inputReason = [
                        'model_name' => 'Futsal',
                        'reason' => $req['reason'],
                        'kode_booking' => $futsal->kode_booking
                    ];
                    ReasonReject::firstOrCreate($inputReason);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success update booking lapangan futsal.'
                    ],200);
                }
            }
        }

    }

    public function uploadFileBuluTangkis(UploadedFile $file) {
        $destinationPath = public_path() . '/uploads/file_futsal/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = $file->getClientOriginalName();
        return $file->move($destinationPath, $fileName);
    }

    public function downloadFutsal($id) {
        $file = FileFutsal::where('futsal_id', $id)->firstOrFail();
        $pathToFile = public_path() . '/uploads/file_futsal/' . $file->file_futsal;

        return response()->download($pathToFile);
    }
}
