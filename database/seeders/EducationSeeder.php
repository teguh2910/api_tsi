<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
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
                'kode'          => 'TK',
                'pendidikan'    => 'Taman Kanak-kanak',
                'level'         => 'Pendidikan Usia Dini',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'SD',
                'pendidikan'    => 'Sekolah Dasar',
                'level'         => 'Pendidikan Dasar',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'SMP',
                'pendidikan'    => 'Sekolah Menengah Pertama',
                'level'         => 'Pendidikan Dasar',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'SMA',
                'pendidikan'    => 'Sekolah Menengah Atas',
                'level'         => 'Pendidikan Dasar',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'D1',
                'pendidikan'    => 'Diploma I',
                'level'         => 'Pendidikan Tinggi',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'D3',
                'pendidikan'    => 'Diploma III',
                'level'         => 'Pendidikan Tinggi',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'S1',
                'pendidikan'    => 'Strata I',
                'level'         => 'Pendidikan Tinggi',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'S2',
                'pendidikan'    => 'Strata II',
                'level'         => 'Pendidikan Tinggi',
                'jenis'         => 'Pendidikan Formal'
            ],
            [
                'kode'          => 'S3',
                'pendidikan'    => 'Strata III',
                'level'         => 'Pendidikan Tinggi',
                'jenis'         => 'Pendidikan Formal'
            ]


        ];
        \DB::table('education')->insert($data);
    }
}
