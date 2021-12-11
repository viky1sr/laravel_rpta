<?php

namespace App\Console\Commands;

use App\Models\Aula;
use App\Models\BuluTangkis;
use App\Models\Futsal;
use App\Models\Laktasi;
use App\Models\Perpustakaan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report daily taks job list';

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
        /*
            Status ID
            1 = Pending,
            2 = OnProgress
            3 = Success
            0 = Reject
        */

        $aulas = Aula::whereDate('tanggal_pemesanan',Carbon::now())
            ->where('status','=',1)
            ->where('created_by','=',1)
            ->get();
        if($aulas) {
            foreach($aulas as $key => $item) {
                $input = [
                    'status' => 3
                ];
                Aula::find($item->id)->update($input);
            }
        }

        $laktasis = Laktasi::whereDate('tanggal_pemesanan',Carbon::now())
            ->where('status','=',1)
            ->where('created_by','=',1)
            ->get();
        if($laktasis) {
            foreach($laktasis as $key => $item) {
                $input = [
                    'status' => 3
                ];
                Laktasi::find($item->id)->update($input);
            }
        }

        $perpustakaan = Perpustakaan::whereDate('tanggal_pemesanan',Carbon::now())
            ->where('status','=',1)
            ->where('created_by','=',1)
            ->get();
        if($perpustakaan) {
            foreach($perpustakaan as $key => $item) {
                $input = [
                    'status' => 3
                ];
                Perpustakaan::find($item->id)->update($input);
            }
        }

        $bulu_tangkis = BuluTangkis::whereDate('tanggal_pemesanan',Carbon::now())
            ->where('status','=',1)
            ->where('created_by','=',1)
            ->get();
        if($bulu_tangkis) {
            foreach($bulu_tangkis as $key => $item) {
                $input = [
                    'status' => 3
                ];
                BuluTangkis::find($item->id)->update($input);
            }
        }

        $futsals = Futsal::whereDate('tanggal_pemesanan',Carbon::now())
            ->where('status','=',1)
            ->where('created_by','=',1)
            ->get();
        if($futsals) {
            foreach($futsals as $key => $item) {
                $input = [
                    'status' => 3
                ];
                Futsal::find($item->id)->update($input);
            }
        }

        $this->info('Successfully update daily to clients.');
    }
}
