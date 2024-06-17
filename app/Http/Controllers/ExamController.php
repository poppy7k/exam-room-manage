<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index() {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
        ];
        session()->flash('sidebar', '3');

        return view('pages.exam-manage.exam-list', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'exam_takers_quantity' => 'required|integer|min:1',
            'building_id' => 'required|string',
            'room_id' => 'required|string',
            'subject' => 'required|string',
            'exam_date' => 'required|string',
        ]);
    
        Exam::create([
            'building_th' => $validatedData['building_th'],
            'building_en' => $validatedData['building_en'],
        ]);
    
        // alerts-box
        session()->flash('status', 'success');
        session()->flash('message', 'สร้างอาคารสอบสำเร็จ!');

    }
    
    public function create() {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'สร้างการสอบ'],
        ];
        session()->flash('sidebar', '3');

        return view('pages.exam-manage.exam-create', compact('breadcrumbs'));
    }
}
