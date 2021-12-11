<?php

namespace Database\Seeders;

use App\Models\MasterWaktuBooking;
use Illuminate\Database\Seeder;

class WaktuBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $waktu = [
            '08.00-10.00',
            '10.00-12.00',
            '13.00-15.00',
            '15.00-17.00',
            '19.00-20.00'
        ];

        foreach($waktu as $eky =>$item) {
            MasterWaktuBooking::firstOrCreate( [
                'waktu' => $item
            ]);
        }
    }
}
