<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Applicant::factory(5)->create();
        $applicant = new Applicant();
        $applicant->id_number = "010001";
        $applicant->id_card = "5 6485 54823 48 6";
        $applicant->name = "นาย --------------01";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "010002";
        $applicant->id_card = "6 1813 48294 81 9";
        $applicant->name = "นาย --------------02";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "010003";
        $applicant->id_card = "4 5841 63218 48 6";
        $applicant->name = "นาย --------------03";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ";
        $applicant->save();
        
        $applicant = new Applicant();
        $applicant->id_number = "010004";
        $applicant->id_card = "1 5842 31448 84 3";
        $applicant->name = "นาย --------------04";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "010005";
        $applicant->id_card = "4 5264 84815 25 6";
        $applicant->name = "นาย --------------05";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ";
        $applicant->save();
    }
}
