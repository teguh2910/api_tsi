<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =[
            [

                'nama'          => [
                    'nama_depan'    => 'Khairon',
                    'nama_belakang' => 'Anas',
                    'nama_lengkap'  => 'Khairon Anas'
                ],
                'gelar'         => [
                    'gelar_depan'   => 'Ns',
                    'gelar_belakang'=> 'AMK, S.Kep., S.Kom., M.Kom, MH'
                ],
                'lahir'         => [
                    'tanggal'       => '1984-09-09',
                    'tempat'        => 'Cirebon'
                ],
                'kontak'        => [
                    'email'        => 'khaironbiz@gmail.com',
                    'nomor_telepon'=> '081213798746'
                ],
                'gender'        => 'male',
                'nik'           => 3209290609840002,
                'username'      => 'khaironbiz@gmail.com',
                'password'      => bcrypt(123456),
                'active'        => true,
                'address'       => [
                    'provinsi'  => [
                        'id_provinsi'       => 31,
                        'nama_provinsi'     => 'Jawa Barat'
                    ],
                    'kota'      => [
                        'id_kota'           => '',
                        'nama_kota'         => 'Kab. Bogor'
                    ],
                    'kecamatan' => [
                        'id_kecamatan'      => '',
                        'nama_kecamatan'    => 'Sukaraja'
                    ],
                    'kelurahan' => [
                        'id_kelurahan'      => '',
                        'nama_kelurahan'    => 'Cilebut Barat'
                    ],
                    'kode_pos'  => 16710
                ],
                'pemeriksaan_kesehatan'=>[
                    'chol' =>[
                        'value'     => 186.6,
                        'unit'      => 'mg/dL',
                        'time'      => ''
                    ],
                    'gluc' =>[
                        'value'    => 106.6,
                        'unit'     => 'mg/dL',
                        'time'      => ''
                    ],
                    'suhu' =>[
                        'value'    => 36.6,
                        'unit'     => 'C',
                        'time'      => ''
                    ],
                    'tb'   =>[
                        'value'    => 165,
                        'unit'     => 'cm',
                        'time'      => ''
                    ],
                    'bb'   =>[
                        'value'    => 72.6,
                        'unit'     => 'Kg',
                        'time'      => ''
                    ],
                    'imt'  =>[
                        'value'    => 24,
                        'unit'     => 'kg/m2',
                        'time'      => ''
                    ]
                ],
                'wallet'       => [
                    'currency' => 'IDR',
                    'value'    => 360000
                ]
            ]
        ];
        \DB::table('users')->insert($data);
    }
}
