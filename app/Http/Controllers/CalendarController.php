<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index() {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'ปฏิทินการสอบ'],
        ];

        return view('pages.calendar.list', compact('breadcrumbs'));
    }
}
