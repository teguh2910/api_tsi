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
                "code"      => "vital-signs",
                "display"   => "Vital Signs",
                "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
            ],
            [
                "code"      => "exam",
                "display"   => "Exam",
                "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"

            ],
            [
                "code"      => "8867-4",
                "display"   => "Heart rate",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "/min",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "beats/minute",
                ]
            ],
            [
                "code"      => "9279-1",
                "display"   => "Respiratory rate",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "/min",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "beats/minute",
                ]
            ],
            [
                "code"      => "8480-6",
                "display"   => "Systolic blood pressure",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "mm[Hg]",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "mm[Hg]",
                ]
            ],
            [
                "code"      => "8462-4",
                "display"   => "Diastolic blood pressure",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "mm[Hg]",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "mm[Hg]",
                ]
            ],
            [
                "code"      => "8310-5",
                "display"   => "Body temperature",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "Cel",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "C",
                ]
            ],
            [
                "code"      => "8302-2",
                "display"   => "Body height",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "cm",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "cm",
                ]
            ],
            [
                "code"      => "8308-9",
                "display"   => "Body height --standing",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "cm",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "cm",
                ]
            ],
            [
                "code"      => "8306-3",
                "display"   => "Body height --lying",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "cm",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "cm",
                ]
            ],
            [
                "code"      => "29463-7",
                "display"   => "Body weight",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "kg",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "kg",
                ]
            ],
            [
                "code"      => "39156-5",
                "display"   => "Body mass index (BMI) [Ratio]",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "kg/m2",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "kg/m2",
                ]
            ],
            [
                "code"      => "9843-4",
                "display"   => "Head Occipital-frontal circumference",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "vital-signs",
                    "display"   => "Vital Signs",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "cm",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "cm",
                ]
            ],
            [
                "code"      => "8280-0",
                "display"   => "Waist Circumference at umbilicus by Tape measure",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "exam",
                    "display"   => "Exam",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "cm",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "cm",
                ]
            ],
            [
                "code"      => "56072-2",
                "display"   => "Circumference Mid upper arm - right",
                "system"    => "http://loinc.org",
                "category"  => [
                    "code"      => "exam",
                    "display"   => "Exam",
                    "system"    => "http://terminology.hl7.org/CodeSystem/observation-category"
                ],
                "unit"      => [
                    "code"      => "cm",
                    "system"    => "http://unitsofmeasure.org",
                    "unit"      => "cm",
                ]
            ]


        ];
        \DB::table('codes')->insert($data);
    }
}
