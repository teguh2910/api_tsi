<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CodeSeeder extends Seeder
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
                "_id"       => "vital-signs",
                "system"    => "http://terminology.hl7.org/CodeSystem/observation-category",
                "display"   => "Vital Signs"
            ],

        ];
        \DB::table('codes')->insert($data);
    }
}
