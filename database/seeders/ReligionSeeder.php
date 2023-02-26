<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
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
                'name'          => 'Islam',
                'kitab_suci'    => 'Al Quran'
            ],
            [
                'name'          => 'Katholik',
                'kitab_suci'    => 'Al Kitab'
            ],
            [
                'name'          => 'Kristen',
                'kitab_suci'    => 'Al Kitab'
            ],
            [
                'name'          => 'Hindu',
                'kitab_suci'    => 'Weda'
            ],
            [
                'name'          => 'Buddha',
                'kitab_suci'    => 'Tripitaka'
            ],
            [
                'name'          => 'Konghuchu',
                'kitab_suci'    => 'Shishu Wujing'
            ],
        ];
        \DB::table('religions')->insert($data);
    }
}
