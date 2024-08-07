<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Exam;

class CalendarController extends Controller
{
    public function index()
    {
        // รับวันที่ปัจจุบัน
        $today = Carbon::today()->format('Y-m-d');

        // ดึงข้อมูล Exam ที่วันที่ตรงกับวันที่ปัจจุบัน
        $exams = Exam::whereDate('exam_date', $today)->get();

        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'ปฏิทินการสอบ'],
        ];

        session()->flash('sidebar', '4');

        return view('pages.calendar.list', compact('breadcrumbs', 'exams'));
    }
}
