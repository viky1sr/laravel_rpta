<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\FileAula;
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
            'title' => 'Aula',
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu'),
            'status' => MasterStatus::where('id','<>',0)->get()->pluck('status_name','status_id'),
            'users' => User::where('id','<>',0)->get()
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
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu'),
            'status' => MasterStatus::where('id','<>',0)->get()->pluck('status_name','status_id')
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
                'messages' => 'Tanggal booking harus H-1.'
            ],422);
        }

        $check = Aula::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
            ->where('waktu_booking',$req['waktu_booking'])
            ->whereIn('status',[2,3])
            ->first();

        $checkAdmin = Aula::whereDate('tanggal_pemesanan','=',Carbon::parse($req['tanggal_pemesanan']))
            ->where('waktu_booking',$req['waktu_booking'])
            ->where('status','=',1)
            ->where('created_by','=',1)
            ->first();

        if($check != null || $checkAdmin != null) {
            return response()->json([
                'status' => 'fail',
                'messages' => 'Waktu booking sudah terisi, silakan pilih waktu yang lain.'
            ],422);
        }

        if($req['type_booking'] == 1) {
            $checkEvent = Aula::whereDate('lama_booking_date','=', Carbon::parse($req['tanggal_pemesanan'])->addDay(1))
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
                    'hari' => Carbon::parse($success->created_at)->format('D')
                ];
                Aula::where('id', $success->id)->update($upCode);
            }

            return response()->json([
                'status' => 'ok',
                'messages' => 'Success Create Booking Aula.',
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
        $array = [
            'id' => $id,
            'title' => 'Info Aula Booking',
            'data' => Aula::with('info_status','is_status')->find($id),
            'file_data' => FileAula::where('aula_id',$id)->first(),
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];

        return view('pages.aula.update_proses',$array);
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
            'id' => $id,
            'title' => 'Update Aula Booking',
            'data' => Aula::find($id),
            'waktus' => MasterWaktuBooking::where('id','<>',0)->get()->pluck('waktu','waktu')
        ];

        return view('pages.aula.create-or-update',$array);
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
        $req = $request->all();
        if(Auth::user()->hasRole('member')) {
            $data = Aula::where('aulas.id','<>' ,0)
                ->where('aulas.created_by','=' ,Auth::user()->id)
                ->leftJoin('master_statuses','master_statuses.status_id','=','aulas.status')
                ->select('aulas.*','master_statuses.status_name');
        } else if(Auth::user()->hasRole('admin')) {
            $data = Aula::where('aulas.id','<>' ,0)
                ->leftJoin('master_statuses','master_statuses.status_id','=','aulas.status')
                ->leftJoin('users','users.id','=','aulas.created_by')
                ->select('aulas.*','master_statuses.status_name',
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
        $check = FileAula::where('aula_id', $id)->first();

        if(empty($check)) {
            $msg = [
                'file_aula.max' => 'File max 25mb.',
                'file_aula.required' => 'Please upload file pendukung.',

            ];
            $validation = Validator::make($req,[
                'file_aula' => 'required|max:25000'
            ],$msg);

            if($validation->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'messages' => $validation->errors()->first()
                ],422);
            } else {

                if ($request->hasFile('file_aula')) {
                    $file = $request->file('file_aula');
                    $file = $this->uploadFileAula($file);
                    $pp =  $request->merge([
                        'file_aula' => $file->getFileInfo()->getFilename(),
                    ]);
                }

                $input = [
                    'aula_id' => $req['aula_id'],
                    'file_aula' => !empty($file) ? $file->getFileInfo()->getFilename() : null
                ];

                $success = FileAula::firstOrCreate($input);
                if($success) {
                    $status = [
                        'status' => 2
                    ];

                    Aula::find($id)->update($status);

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
                    Aula::find($id)->update($status);

                    return response()->json([
                        'status' => 'ok',
                        'messages' => 'Success update booking Aula.'
                    ],200);
                } else {
                    $status = [
                        'status' => $req['status']
                    ];
                    Aula::find($id)->update($status);

                    $aula = Aula::find($id);

                    $inputReason = [
                        'model_name' => 'Aula',
                        'reason' => $req['reason'],
                        'kode_booking' => $aula->kode_booking
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

    public function uploadFileAula(UploadedFile $file) {
        $destinationPath = public_path() . '/uploads/file_aula/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = $file->getClientOriginalName();
        return $file->move($destinationPath, $fileName);
    }

    public function downloadAula($id) {
        $file = FileAula::where('aula_id', $id)->firstOrFail();
        $pathToFile = public_path() . '/uploads/file_aula/' . $file->file_aula;

        return response()->download($pathToFile);
    }
}
