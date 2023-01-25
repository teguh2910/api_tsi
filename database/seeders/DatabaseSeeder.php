<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProvinceSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            VillageSeeder::class,
            ReligionSeeder::class,
            CustomerSeeder::class,
            UserSeeder::class,
            ProfesionSeeder::class,
            EducationSeeder::class,
            CodeSeeder::class

        ]);
//
    }
}
