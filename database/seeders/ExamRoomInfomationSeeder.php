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
        $examroominfo->building_id = "1";
        $examroominfo->floor = "2";
        $examroominfo->room = "213";
        $examroominfo->rows = 5;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 50;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "1";
        $examroominfo->floor = "3";
        $examroominfo->room = "332";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "1";
        $examroominfo->floor = "3";
        $examroominfo->room = "333";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "1";
        $examroominfo->floor = "3";
        $examroominfo->room = "334";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "2";
        $examroominfo->room = "202";
        $examroominfo->rows = 5;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 50;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "2";
        $examroominfo->room = "203";
        $examroominfo->rows = 5;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 50;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "2";
        $examroominfo->room = "204";
        $examroominfo->rows = 5;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 50;
        $examroominfo->total_seat = 50;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "3";
        $examroominfo->room = "301";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "3";
        $examroominfo->room = "302";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "3";
        $examroominfo->room = "304";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "401";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "402";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "403";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "2";
        $examroominfo->floor = "4";
        $examroominfo->room = "404";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "3";
        $examroominfo->floor = NULL;
        $examroominfo->room = "902";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "3";
        $examroominfo->floor = NULL;
        $examroominfo->room = "1002";
        $examroominfo->rows = 15;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 150;
        $examroominfo->total_seat = 150;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "4";
        $examroominfo->floor = "4";
        $examroominfo->room = NULL;
        $examroominfo->rows = 30;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 300;
        $examroominfo->total_seat = 300;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "5";
        $examroominfo->floor = NULL;
        $examroominfo->room = "ศูนย์กิจกรรมนิสิต";
        $examroominfo->rows = 10;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 100;
        $examroominfo->total_seat = 100;
        $examroominfo->save();

        $examroominfo = new ExamRoomInformation();
        $examroominfo->building_id = "6";
        $examroominfo->floor = NULL;
        $examroominfo->room = "สุธรรม";
        $examroominfo->rows = 30;
        $examroominfo->columns = 10;
        $examroominfo->valid_seat = 300;
        $examroominfo->total_seat = 300;
        $examroominfo->save();

    }
}
