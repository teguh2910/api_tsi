<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'name'      => 'Blood Pressure',
                'category'  => 'Al Quran',
                ''          => '',
                ''          => '',
                ''          => ''
            ],

        ];
        \DB::table('devices')->insert($data);
    }
}
