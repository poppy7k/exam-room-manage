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
        $applicant = new Applicant();
        $applicant->id_number = "060001";
        $applicant->id_card = "7 6485 55823 68 6";
        $applicant->name = "นาย --------------01(06)";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ5";
        $applicant->department = "งานบริหารระบบเอกสารกลาง5";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "050001";
        $applicant->id_card = "1 6485 55823 68 6";
        $applicant->name = "นาย --------------01(05)";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ4";
        $applicant->department = "งานบริหารระบบเอกสารกลาง4";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "040001";
        $applicant->id_card = "5 6485 55823 68 6";
        $applicant->name = "นาย --------------01(04)";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ3";
        $applicant->department = "งานบริหารระบบเอกสารกลาง3";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "030001";
        $applicant->id_card = "5 6485 54823 48 3";
        $applicant->name = "นาย --------------01(03)";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ2";
        $applicant->department = "งานบริหารระบบเอกสารกลาง2";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "020001";
        $applicant->id_card = "5 6485 54823 48 6";
        $applicant->name = "นาย --------------01(cf01)";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ1";
        $applicant->department = "งานบริหารระบบเอกสารกลาง1";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "020002";
        $applicant->id_card = "5 6485 54823 48 6";
        $applicant->name = "นาย --------------01(cf02)";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ1";
        $applicant->department = "งานบริหารระบบเอกสารกลาง1";
        $applicant->save();

        $applicant = new Applicant();
        $applicant->id_number = "010001";
        $applicant->id_card = "5 6485 54823 48 6";
        $applicant->name = "นาย --------------01";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ";
        $applicant->department = "งานบริหารระบบเอกสารกลาง";
        $applicant->save();

        $faker = \Faker\Factory::create('th_TH'); // Use Thai locale for more realistic data

        for ($i = 2; $i <= 150; $i++) {
            $id_number = str_pad($i, 3, '0', STR_PAD_LEFT); // Pad the number to 6 digits
            $applicant = new Applicant();
            $applicant->id_number = "010" . $id_number;
            $applicant->id_card = $faker->numerify('# #### ##### ## #'); // Generate random Thai ID card format
            $applicant->name = "นาย --------------" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $applicant->degree = "ระดับปริญญาตรี";
            $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ";
            $applicant->department = "งานบริหารระบบเอกสารกลาง";
            $applicant->save();
        }

        for ($i = 1; $i <= 150; $i++) {
            $id_number = str_pad($i, 3, '0', STR_PAD_LEFT); // Pad the number to 6 digits
            $applicant = new Applicant();
            $applicant->id_number = "070" . $id_number;
            $applicant->id_card = $faker->numerify('# #### ##### ## #'); // Generate random Thai ID card format
            $applicant->name = "นาย --------------" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $applicant->degree = "ระดับปริญญาตรี";
            $applicant->position = "นักประชาสัมพันธ์ระดับปฏิบัติการ";
            $applicant->department = "งานสื่อสารองค์กร";
            $applicant->save();
        }

        $applicant = new Applicant();
        $applicant->id_number = "060002";
        $applicant->id_card = "7 6485 55345 68 6";
        $applicant->name = "นาย --------------02(06)";
        $applicant->degree = "ระดับปริญญาตรี";
        $applicant->position = "เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ5";
        $applicant->department = "งานบริหารระบบเอกสารกลาง5";
        $applicant->save();
    }
}
