<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;

class SelectedRoomController extends Controller
{
    public function showSelectedRooms($examId)
    {
        $exams = Exam::findOrFail($examId);
        $selectedRooms = $exams->selectedRooms;
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/buildings', 'title' => ''.$exams->department_name],
        ];
        session()->flash('sidebar', '3');
    
        return view('pages.exam-manage.exam-selectedroom', compact('exams', 'selectedRooms','breadcrumbs'));
    }
}
