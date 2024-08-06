<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\SelectedRoom;

class SelectedRoomController extends Controller
{
    public function showSelectedRooms($examId, Request $request)
    {
        // ดึงข้อมูลการสอบตาม examId
        $exams = Exam::findOrFail($examId);
        
        // เริ่มสร้าง query สำหรับ SelectedRoom
        $selectedRoomsQuery = SelectedRoom::query()
            ->join('exam_room_information', 'selected_rooms.room_id', '=', 'exam_room_information.id')
            ->where('selected_rooms.exam_id', $examId);
        
        // จัดเรียงตาม room_name
        $sort = $request->get('sort', 'room_name_asc');
        switch ($sort) {
            case 'room_name_asc':
                $selectedRoomsQuery->orderBy('exam_room_information.room', 'asc');
                break;
            case 'room_name_desc':
                $selectedRoomsQuery->orderBy('exam_room_information.room', 'desc');
                break;
            default:
                $selectedRoomsQuery->orderBy('exam_room_information.room', 'asc');
        }
        
        // ใช้ paginate กับ query ที่สร้าง
        $selectedRooms = $selectedRoomsQuery->paginate(12, ['selected_rooms.*']);

        $applicantsWithSeats = $exams->applicants()->wherePivot('status', 'assigned')->count();
        $totalApplicants = $exams->applicants()->count();
        $applicantsWithoutSeats = $exams->applicants()->wherePivot('status', 'not_assigned')->get();

        // สร้าง breadcrumbs
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/buildings', 'title' => $exams->department_name],
        ];

        // ตั้งค่า sidebar ใน session
        session()->flash('sidebar', '3');

        // ส่งข้อมูลไปยัง view
        return view('pages.exam-manage.exam-selectedroom', compact('exams', 'selectedRooms', 'breadcrumbs', 'applicantsWithSeats', 'totalApplicants', 'applicantsWithoutSeats'));
    }
}
