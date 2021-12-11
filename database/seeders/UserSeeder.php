<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User seeder
        $admin = User::firstOrCreate(
            [
                'email' => 'rptra.rasamala@gmail.com'
            ],
            [
                'first_name' => 'Rptra',
                'last_name' => 'Rasamala',
                'nik' => '20221181013',
                'password' => Hash::make('mendal'),
                'email_verified_at' => Carbon::now()
            ]);
        $admin->assignRole('admin');

        // User seeder
        $member = User::firstOrCreate(
            [
                'email' => 'member@demo.id'
            ],
            [
                'first_name' => 'Member',
                'last_name' => 'Testing',
                'nik' => '1010102022',
                'password' => Hash::make('123123'),
                'email_verified_at' => Carbon::now()
            ]);
        $member->assignRole('member');
    }
}
