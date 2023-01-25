<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesionSeeder extends Seeder
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
                'nama_profesi'  => 'Perawat',
                'organisasi'    => [
                    'nama_organisasi'   => '',
                    'nama_pemimpin'     => '',
                    'address'           => [
                        'alamat_kantor' => [
                            'provinsi'  => '',
                            'kota'      => '',
                            'kecamatan' => '',
                            'kelurahan' => '',
                            'kode_pos'  => ''
                        ],
                        'email'         => '',
                        'hp'            => '',
                        'phone'         => '',
                        'website'       => '',
                    ],
                    'cabang_provinsi'   => [
                      [
                          'kode_provinsi'   => '',
                          'nama_provinsi'   => '',
                          'nama_organisasi' => '',
                          'nama_pemimpin'     => '',
                          'address'           => [
                              'alamat_kantor' => [
                                  'provinsi'  => '',
                                  'kota'      => '',
                                  'kecamatan' => '',
                                  'kelurahan' => '',
                                  'kode_pos'  => ''
                              ],
                              'email'         => '',
                              'hp'            => '',
                              'phone'         => '',
                              'website'       => '',
                          ],
                          'cabang_kota'     => [
                              [
                                  'kode_kota'   => '',
                                  'nama_kota'   => '',
                                  'nama_organisasi' => '',
                                  'nama_pemimpin'     => '',
                                  'address'           => [
                                      'alamat_kantor' => [
                                          'provinsi'  => '',
                                          'kota'      => '',
                                          'kecamatan' => '',
                                          'kelurahan' => '',
                                          'kode_pos'  => ''
                                      ],
                                      'email'         => '',
                                      'hp'            => '',
                                      'phone'         => '',
                                      'website'       => '',
                                  ],



                              ]
                          ]
                      ]
                    ],
                    'cabang_luar_negeri'    => [
                        [
                            'kode_negara'   => '',
                            'nama_negara'   => '',
                            'nama_organisasi' => '',
                            'nama_pemimpin' => '',
                            'address'       => '',
                            'email'         => '',
                            'hp'            => '',
                            'phone'         => '',
                            'website'       => '',

                        ]
                    ]
                ]
            ]
        ];
        \DB::table('profesions')->insert($data);
    }
}
