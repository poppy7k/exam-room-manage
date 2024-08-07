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
use App\Http\Controllers\NotificationController;


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

Route::get('/buildings/{buildingId}/addinfo/{roomId}/addsReat', [ExamRoomInformationController::class, 'addSeat'])->name('addseat');
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

Route::post('/create-exams', [ExamController::class, 'createExams'])->name('create-exams');
Route::get('/exams/{examId}/selectedrooms', [SelectedRoomController::class, 'showSelectedRooms'])->name('exam-selectedroom');
Route::get('/exams/{examId}/selectedrooms/{selected_room_id}', [ExamController::class, 'showExamRoomDetail'])->name('exam-roomdetail');

Route::get('/calendar/exams/{date}', [ExamController::class, 'getExamsByDate']);

// Alert //
Route::post('/set-alert-message', function (Illuminate\Http\Request $request) {
    session()->flash('status', 'success');
    session()->flash('message', $request->message);
});
Route::post('/notifications', [NotificationController::class, 'show'])->name('notifications.show');

// Calendar //
Route::get('/calendar', [CalendarController::class, 'index'])->name('pages.calendar.list');
Route::get('/calendar/exams', [ExamController::class, 'getExam'])->name('exam.getExam');

// Staff //
Route::get('/staffs', [StaffController::class, 'index'])->name('staffs.index');
Route::post('/save-staffs', [StaffController::class, 'saveStaffs']);

Route::get('/get-applicants-without-seats/{examId}/{roomId}', [ApplicantController::class, 'getApplicantsWithoutSeats']);
Route::post('/save-applicant-to-seat', [SeatController::class, 'saveApplicantToSeat']);
Route::post('/remove-applicant-from-seat', [SeatController::class, 'removeApplicantFromSeat']);
Route::post('/remove-applicants-from-room', [SeatController::class, 'removeApplicantsFromRoom']);
Route::post('/update-valid-seat-count', [SeatController::class, 'updateValidSeatCount']);
Route::put('/exams/update', [ExamController::class, 'updateExam'])->name('update-exam');
Route::get('/update-exam-statuses', [ExamController::class, 'updateExamStatuses']);

Route::get('/check-seat-deactivation/{seatId}', [ExamController::class, 'checkSeatDeactivation']);

Route::post('/update-applicant-status', [ApplicantController::class, 'updateApplicantExamStatus']);

Route::post('/exams-with-affected-layouts', [ExamController::class, 'getExamsWithAffectedChangeLayouts']);
Route::post('/update-exam-seat-layouts', [ExamController::class, 'updateExamSeatLayouts']);

Route::post('/assign-all-applicants-to-seats', [SeatController::class, 'assignAllApplicantsToSeats']);

Route::get('/get-new-applicants/{examId}', [ApplicantController::class,'getNewApplicants']);
Route::post('/update-new-applicants/{examId}', [ApplicantController::class,'updateNewApplicants']);

Route::get('/get-applicants-to-delete/{examId}', [ApplicantController::class, 'getApplicantsToDelete']);
Route::post('/delete-applicants/{examId}', [ApplicantController::class, 'deleteApplicants']);

Route::get('/fetch-applicants', [ApplicantController::class, 'fetchApplicants'])->name('fetch.applicants');

Route::get('/hide-or-show-remove-applicant-button/{applicantId}/{examId}/{roomId}', [ExamController::class, 'hideOrShowRemoveApplicantButton']);
