<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
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
                'code'          => 'A',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Annulled',
                'definition'    => 'Marriage contract has been declared null and to not have existed'
            ],
            [
                'code'          => 'D',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Divorced',
                'definition'    => 'Marriage contract has been declared dissolved and inactive'
            ],
            [
                'code'          => 'I',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Interlocutory',
                'definition'    => 'Subject to an Interlocutory Decree.'
            ],
            [
                'code'          => 'L',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Legally Separated',
                'definition'    => 'Cerai resmi'
            ],
            [
                'code'          => 'M',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Married',
                'definition'    => 'A current marriage contract is active'
            ],
            [
                'code'          => 'C',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Common Law',
                'definition'    => "a marriage recognized in some jurisdictions and based on the parties agreement to consider themselves married and can also be based on documentation of cohabitation. This definition was based on https://www.merriam-webster.com/dictionary/common-law%20marriage."
            ],
            [
                'code'          => 'P',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Polygamous',
                'definition'    => 'More than 1 current spouse'
            ],
            [
                'code'          => 'T',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Domestic partner',
                'definition'    => 'Person declares that a domestic partner relationship exists.'
            ],
            [
                'code'          => 'U',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'unmarried',
                'definition'    => 'Currently not in a marriage contract.'
            ],
            [
                'code'          => 'S',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Never Married',
                'definition'    => 'No marriage contract has ever been entered'
            ],
            [
                'code'          => 'W',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'Widowed',
                'definition'    => 'The spouse has died'
            ],
            [
                'code'          => 'UNK',
                'system'        => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                'display'       => 'unknown',
                'definition'    => "A proper value is applicable, but not known"
            ],
        ];
        \DB::table('marital_statuses')->insert($data);
    }
}
