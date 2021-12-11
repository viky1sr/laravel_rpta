<?php

namespace Database\Seeders;

use App\Models\MasterStatus;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            'Reject',
            'Pending',
            'On Progress',
            'Success',
        ];

        foreach ($status as $key => $value) {
            MasterStatus::firstOrCreate([
                'status_id' => $key,
                'status_name' => $value
            ]);
        }
    }
}
