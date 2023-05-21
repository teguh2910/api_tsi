<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'      => 'Perawat',
                'count'     => '',
            ],
            [
                'name'      => 'Dokter',
                'count'     => '',
            ],
            [
                'name'      => 'Apoteker',
                'count'     => '',
            ],
            [
                'name'      => 'Bidan',
                'count'     => '',
            ],
            [
                'name'      => 'Dietisien',
                'count'     => '',
            ],
            [
                'name'      => 'Dokter Gigi',
                'count'     => '',
            ],
            [
                'name'      => 'Penata Anestesi',
                'count'     => '',
            ]

        ];
        \DB::table('profesions')->insert($data);
    }
}
