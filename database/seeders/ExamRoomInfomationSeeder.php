<?php

namespace Database\Seeders;

use App\Models\ExamRoomInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamRoomInfomationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.1";
        $examroominfo->building_code = "1";
        $examroominfo->floor = "2";
        $examroominfo->room = "213";
        $examroominfo->valid_seat = 28;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.1";
        $examroominfo->building_code = "1";
        $examroominfo->floor = "3";
        $examroominfo->room = "332";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.1";
        $examroominfo->building_code = "1";
        $examroominfo->floor = "3";
        $examroominfo->room = "333";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.1";
        $examroominfo->building_code = "1";
        $examroominfo->floor = "3";
        $examroominfo->room = "334";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "2";
        $examroominfo->room = "202";
        $examroominfo->valid_seat = 50;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "2";
        $examroominfo->room = "203";
        $examroominfo->valid_seat = 50;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "2";
        $examroominfo->room = "204";
        $examroominfo->valid_seat = 39;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "3";
        $examroominfo->room = "301";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "3";
        $examroominfo->room = "302";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "3";
        $examroominfo->room = "304";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "401";
        $examroominfo->valid_seat = 156;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "402";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "403";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.3";
        $examroominfo->building_code = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "404";
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.4";
        $examroominfo->building_code = "3";
        $examroominfo->floor = "";
        $examroominfo->room = "902";
        $examroominfo->valid_seat = 144;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "ศร.4";
        $examroominfo->building_code = "3";
        $examroominfo->floor = "";
        $examroominfo->room = "1002";
        $examroominfo->valid_seat = 144;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "เทพฯ";
        $examroominfo->building_code = "4";
        $examroominfo->floor = "4";
        $examroominfo->room = "";
        $examroominfo->valid_seat = 292;
        $examroominfo->total_seat = 300;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "กิจกรรมนิสิต";
        $examroominfo->building_code = "5";
        $examroominfo->floor = "";
        $examroominfo->room = "ศูนย์กิจกรรมนิสิต";
        $examroominfo->valid_seat = 124;
        $examroominfo->total_seat = 100;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_name = "50ปี";
        $examroominfo->building_code = "6";
        $examroominfo->floor = "";
        $examroominfo->room = "สุธรรม";
        $examroominfo->valid_seat = 301;
        $examroominfo->total_seat = 300;
        $examroominfo->save();

    }
}
