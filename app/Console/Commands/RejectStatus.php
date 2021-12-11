<?php

namespace App\Console\Commands;

use App\Models\Aula;
use App\Models\BuluTangkis;
use App\Models\Futsal;
use App\Models\Laktasi;
use App\Models\Perpustakaan;
use App\Models\ReasonReject;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class RejectStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reject_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $aulas = Aula::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i')"),'<=',Carbon::now()->addHour(-2)->format('Y-m-d H:i'))
            ->where('status','=',1)
            ->where('created_by','!=',1)
            ->get();
        if($aulas) {
            foreach($aulas as $key => $item) {
                $input = [
                    'status' => 0
                ];
                $success = Aula::find($item->id);
                $success->update($input);

                $inputReason = [
                    'model_name' => 'Aula',
                    'reason' => 'Tidak upload file dalam 2 jam.',
                    'kode_booking' => $success->kode_booking
                ];
                ReasonReject::firstOrCreate($inputReason);
            }
        }

        $laktasis = Laktasi::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i')"),'<=',Carbon::now()->addHour(-2)->format('Y-m-d H:i'))
            ->where('status','=',1)
            ->where('created_by','!=',1)
            ->get();
        if($laktasis) {
            foreach($laktasis as $key => $item) {
                $input = [
                    'status' => 0
                ];
                $success = Laktasi::find($item->id);
                $success->update($input);

                $inputReason = [
                    'model_name' => 'Laktasi',
                    'reason' => 'Tidak upload file dalam 2 jam.',
                    'kode_booking' => $success->kode_booking
                ];
                ReasonReject::firstOrCreate($inputReason);
            }
        }

        $perpustakaan = Perpustakaan::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i')"),'<=',Carbon::now()->addHour(-2)->format('Y-m-d H:i'))
            ->where('status','=',1)
            ->where('created_by','!=',1)
            ->get();
        if($perpustakaan) {
            foreach($perpustakaan as $key => $item) {
                $input = [
                    'status' => 0
                ];
                $success = Perpustakaan::find($item->id);
                $success->update($input);

                $inputReason = [
                    'model_name' => 'Perpustakaan',
                    'reason' => 'Tidak upload file dalam 2 jam.',
                    'kode_booking' => $success->kode_booking
                ];
                ReasonReject::firstOrCreate($inputReason);
            }
        }

        $bulu_tangkis = BuluTangkis::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i')"),'<=',Carbon::now()->addHour(-2)->format('Y-m-d H:i'))
            ->where('status','=',1)
            ->where('created_by','!=',1)
            ->get();
        if($bulu_tangkis) {
            foreach($bulu_tangkis as $key => $item) {
                $input = [
                    'status' => 0
                ];
                $success = BuluTangkis::find($item->id);
                $success->update($input);

                $inputReason = [
                    'model_name' => 'Bulu Tangkis',
                    'reason' => 'Tidak upload file dalam 2 jam.',
                    'kode_booking' => $success->kode_booking
                ];
                ReasonReject::firstOrCreate($inputReason);
            }
        }

        $futsals = Futsal::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i')"),'<=',Carbon::now()->addHour(-2)->format('Y-m-d H:i'))
            ->where('status','=',1)
            ->where('created_by','!=',1)
            ->get();
        if($futsals) {
            foreach($futsals as $key => $item) {
                $input = [
                    'status' => 0
                ];
                $success = Futsal::find($item->id);
                $success->update($input);

                $inputReason = [
                    'model_name' => 'Futsal',
                    'reason' => 'Tidak upload file dalam 2 jam.',
                    'kode_booking' => $success->kode_booking
                ];
                ReasonReject::firstOrCreate($inputReason);
            }
        }

        $this->info('Successfully update status.');
    }
}
