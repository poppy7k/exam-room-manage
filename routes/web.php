<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamRoomInformationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SelectedRoomController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\SeatController;


Route::get('/', [BuildingController::class, 'index'])->name('index');

Route::get('/buildings', [BuildingController::class, 'building_list'])->name('building-list');
Route::get('/buildings/add', [BuildingController::class, 'create'])->name('pages.building-create');

Route::post('/buildings/store', [BuildingController::class, 'store'])->name('buildings.store');

Route::get('/buildings/{buildingId}/addinfo', function($buildingId) {
    return view('buildings.addinfo', ['buildingId' => $buildingId]);
})->name('buildings.addinfo');

Route::get('/buildings/{buildingId}/exam-room-info/create', [ExamRoomInformationController::class, 'create'])->name('examroominfo.create');

Route::delete('/buildings/{buildingId}', [BuildingController::class, 'destroy'])->name('buildings.destroy');

Route::get('/buildings/{buildingId}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
Route::put('/buildings/{buildingId}', [BuildingController::class, 'update'])->name('buildings.update');

Route::put('/buildings/{buildingId}/ajax', [BuildingController::class, 'updateAjax'])->name('buildings.updateAjax');

Route::get('/buildings/{buildingId}/room-list', [ExamRoomInformationController::class, 'showRoomList'])->name('pages.room-list');

Route::get('/buildings/{buildingId}/addinfo/{roomId}/addseat', [ExamRoomInformationController::class, 'addSeat'])->name('addseat');
Route::put('/rooms/{roomId}/update', [ExamRoomInformationController::class, 'updateRoom'])->name('examroominfo.update');
Route::delete('/rooms/{roomId}', [ExamRoomInformationController::class, 'deleteRoom'])->name('rooms.delete');

Route::get('/buildings/{buildingId}/room-list/add', [ExamRoomInformationController::class, 'create'])->name('pages.room-create');
Route::post('/buildings/{buildingId}/room-list/store', [ExamRoomInformationController::class, 'store'])->name('examroominfo.store');

Route::delete('/examrooms/{roomId}', [ExamRoomInformationController::class, 'destroy'])->name('examroominfo.destory');
Route::get('/buildings/{buildingId}/room-list/{roomId}', [ExamRoomInformationController::class, 'showRoomDetail'])->name('room-detail');

Route::put('/buildings/{buildingId}/room-list/{roomId}', [ExamRoomInformationController::class, 'saveInvalidSeats'])->name('examroominfo.saveInvalidSeats');
// Route::match(['post', 'put'], '/buildings/{buildingId}/room-list/{roomId}/save-selected-seats', [ExamRoomInformationController::class, 'saveSelectedSeats'])->name('examroominfo.saveSelectedSeats');

// Exam-Manage //
Route::get('/exams', [ExamController::class, 'index'])->name('exam-list');
Route::get('/exams/create', [ExamController::class, 'create'])->name('exam-create');
Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
Route::delete('/exams/{examId}', [ExamController::class, 'destroy'])->name('exams.destroy');

Route::get('/exams/{examId}/buildings', [ExamController::class, 'showExamBuildingList'])->name('exam-buildinglist');
Route::get('/exams/{examId}/buildings/{buildingId}', [ExamController::class, 'showExamRoomList'])->name('exam-roomlist');

Route::post('/update-exam-status', [ExamController::class, 'updateExamStatus'])->name('update-exam-status');
Route::get('/exams/{examId}/selectedrooms', [SelectedRoomController::class, 'showSelectedRooms'])->name('exam-selectedroom');
Route::get('/exams/{examId}/selectedrooms/{selected_room_id}', [ExamController::class, 'showExamRoomDetail'])->name('exam-roomdetail');

// Alert //
Route::post('/set-alert-message', function (Illuminate\Http\Request $request) {
    session()->flash('status', 'success');
    session()->flash('message', $request->message);
});

// Calendar //
Route::get('/calendar', [CalendarController::class, 'index'])->name('pages.calendar');
Route::get('/calendar/exams', [ExamController::class, 'getExam'])->name('exam.getExam');

Route::get('/staffs', [StaffController::class, 'index'])->name('staffs.index');
Route::post('/save-staffs', [StaffController::class, 'saveStaffs']);

Route::get('/get-applicants-without-seats/{examId}/{roomId}', [ApplicantController::class, 'getApplicantsWithoutSeats']);
Route::post('/save-applicant-to-seat', [SeatController::class, 'saveApplicantToSeat']);
Route::post('/remove-applicant-from-seat', [SeatController::class, 'removeApplicantFromSeat']);
Route::post('/update-valid-seat-count', [SeatController::class, 'updateValidSeatCount']);
Route::put('/exams/update', [ExamController::class, 'updateExam'])->name('update-exam');