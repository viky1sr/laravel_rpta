<?php

namespace App\Console\Commands;

use App\Models\Aula;
use App\Models\BuluTangkis;
use App\Models\Futsal;
use App\Models\Laktasi;
use App\Models\Perpustakaan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Genetika as ModelGenetika;

class Genetika extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:genetika';

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
        //get Evaluasi Fitnes
        $getEvaluasis = ModelGenetika::whereDate('tanggal_pemesanan','<=',Carbon::now())->get();

        //Seleksi Indivindu
        foreach($getEvaluasis as $key => $item){

            // Cek type pelaksanaan dan total runing penjadwalan
            if($item->total_runing < $item->lama_booking ){
                /*
                 * Cek Type Booking
                 *  1 = Event
                 *  2 = Reguler
                 */

                $digits = 4;
                $random = rand(pow(10, $digits-1), pow(10, $digits)-1);

                // Penjadwalan dalam perhari
                if($item->type == 1){
                    $eCalDay = $item->total_runing;
                    $eDay = Carbon::now()->addDay($eCalDay);
                    $dataEveryDay = ModelGenetika::whereDate('tanggal_pemesanan',$eDay)->get();
                    foreach($dataEveryDay as $keyDay => $itemDay){
                        $inputDay = [
                            'status' => 3,
                            'tanggal_pemesanan' => $itemDay->tanggal_pemesanan,
                            'waktu_booking' => $itemDay->waktu_booking,
                            'nama_pemesan' => $itemDay->nama_pemesan,
                            'instansi' => $itemDay->instansi,
                            'tujuan_kegiatan' => $itemDay->tujuan_kegiatan,
                            'hari' => '-',
                            'no_hp' => $itemDay->no_hp,
                            'created_by' => $itemDay->created_by,
                            'type_booking' => $itemDay->type,
                            'model' => $itemDay->model
                        ];

                        if($item->model == 'Ruang Perpustakaan' && $inputDay['model'] == 'Ruang Perpustakaan'){
                            unset($inputDay['model']);
                            Perpustakaan::firstOrCreate(array_merge($inputDay,['kode_booking' => 'RP'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Ruang Aula' && $inputDay['model'] == 'Ruang Aula'){
                            unset($inputDay['model']);
                            Aula::firstOrCreate(array_merge($inputDay,['kode_booking' => 'AU'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Ruang Laktaksi' && $inputDay['model'] == 'Ruang Laktaksi'){
                            unset($inputDay['model']);
                            Laktasi::firstOrCreate(array_merge($inputDay,['kode_booking' => 'RL'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Lapangan Bulu Tangkis' && $inputDay['model'] == 'Lapangan Bulu Tangkis'){
                            unset($inputDay['model']);
                            BuluTangkis::firstOrCreate(array_merge($inputDay,['kode_booking' => 'BT'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Lapangan Futsal' && $inputDay['model'] == 'Lapangan Futsal'){
                            unset($inputDay['model']);
                            Futsal::firstOrCreate(array_merge($inputDay,['kode_booking' => 'LF'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                    }
                }

                // Penjadwalan dalam perminggu
                if($item->type == 2){
                    // Type Reguler Check Runing ( ( (Waktu Booking start < lama_booking ) + 7) *  lama_booking  )
                    // atau ( Waktu Booking start != 0 , Waktu Booking start < lama_booking = Waktu Booking start * 7 )

                    if($item->total_runing == 0){
                        // First Time created Pelaksanaan

                        $input = [
                            'status' => 3,
                            'tanggal_pemesanan' => $item->tanggal_pemesanan,
                            'waktu_booking' => $item->waktu_booking,
                            'nama_pemesan' => $item->nama_pemesan,
                            'instansi' => $item->instansi,
                            'tujuan_kegiatan' => $item->tujuan_kegiatan,
                            'hari' => '-',
                            'no_hp' => $item->no_hp,
                            'created_by' => $item->created_by,
                            'type_booking' => $item->type,
                            'model' => $item->model
                        ];

                        if($item->model == 'Ruang Perpustakaan' && $input['model'] == 'Ruang Perpustakaan'){
                            unset($input['model']);
                            Perpustakaan::firstOrCreate(array_merge($input,['kode_booking' => 'RP'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Ruang Aula' && $input['model'] == 'Ruang Aula'){
                            unset($input['model']);
                            Aula::firstOrCreate(array_merge($input,['kode_booking' => 'AU'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Ruang Laktaksi' && $input['model'] == 'Ruang Laktaksi'){
                            unset($input['model']);
                            Laktasi::firstOrCreate(array_merge($input,['kode_booking' => 'RL'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Lapangan Bulu Tangkis' && $input['model'] == 'Lapangan Bulu Tangkis'){
                            unset($input['model']);
                            BuluTangkis::firstOrCreate(array_merge($input,['kode_booking' => 'BT'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                        if($item->model == 'Lapangan Futsal' && $input['model'] == 'Lapangan Futsal'){
                            unset($input['model']);
                            Futsal::firstOrCreate(array_merge($input,['kode_booking' => 'LF'.$random ]));
                            ModelGenetika::where('id',$item->id)->update([
                                'total_runing' => $item->total_runing + 1
                            ]);
                        }
                    } else {
                        // Calculasi Pelaksanaan yang sudah jalan +7 hari
                        $calDay = $item->total_runing * 7;
                        $dayCal = Carbon::now()->addDay($calDay);
                        $dataCal = ModelGenetika::whereDate('tanggal_pemesanan',$dayCal)->get();

                        foreach($dataCal as $keyCal => $itemCal){
                            $inputCal = [
                                'status' => 3,
                                'tanggal_pemesanan' => $itemCal->tanggal_pemesanan,
                                'waktu_booking' => $itemCal->waktu_booking,
                                'nama_pemesan' => $itemCal->nama_pemesan,
                                'instansi' => $itemCal->instansi,
                                'tujuan_kegiatan' => $itemCal->tujuan_kegiatan,
                                'hari' => '-',
                                'no_hp' => $itemCal->no_hp,
                                'created_by' => $itemCal->created_by,
                                'type_booking' => $itemCal->type,
                                'model'=> $itemCal->model
                            ];

                            if($itemCal->model == 'Ruang Perpustakaan' && $inputCal['model'] == 'Ruang Perpustakaan'){
                                unset($inputCal['model']);
                                Perpustakaan::firstOrCreate(array_merge($inputCal,['kode_booking' => 'RP'.$random ]));
                                ModelGenetika::where('id',$itemCal->id)->update([
                                    'total_runing' => $itemCal->total_runing + 1
                                ]);
                            }
                            if($itemCal->model == 'Ruang Aula' && $inputCal['model'] == 'Ruang Aula'){
                                unset($inputCal['model']);
                                Aula::firstOrCreate(array_merge($inputCal,['kode_booking' => 'AU'.$random ]));
                                ModelGenetika::where('id',$itemCal->id)->update([
                                    'total_runing' => $itemCal->total_runing + 1
                                ]);
                            }
                            if($itemCal->model == 'Ruang Laktaksi' && $inputCal['model'] == 'Ruang Laktaksi'){
                                unset($inputCal['model']);
                                Laktasi::firstOrCreate(array_merge($inputCal,['kode_booking' => 'RL'.$random ]));
                                ModelGenetika::where('id',$itemCal->id)->update([
                                    'total_runing' => $itemCal->total_runing + 1
                                ]);
                            }
                            if($itemCal->model == 'Lapangan Bulu Tangkis' && $inputCal['model'] == 'Lapangan Bulu Tangkis'){
                                unset($inputCal['model']);
                                BuluTangkis::firstOrCreate(array_merge($inputCal,['kode_booking' => 'BT'.$random ]));
                                ModelGenetika::where('id',$itemCal->id)->update([
                                    'total_runing' => $itemCal->total_runing + 1
                                ]);
                            }
                            if($itemCal->model == 'Lapangan Futsal' && $inputCal['model'] == 'Lapangan Futsal'){
                                unset($inputCal['model']);
                                Futsal::firstOrCreate(array_merge($inputCal,['kode_booking' => 'LF'.$random ]));
                                ModelGenetika::where('id',$itemCal->id)->update([
                                    'total_runing' => $itemCal->total_runing + 1
                                ]);
                            }
                        }
                    }
                }
            }
        }

        $this->info('Successfully create penjadwalan.');
    }
}
