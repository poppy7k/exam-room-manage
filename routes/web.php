<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamRoomInformationController;
use App\Models\ExamRoomInformation;

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

Route::get('/buildings/{buildingId}/room-list', [BuildingController::class, 'showRoomList'])->name('pages.room-list');

Route::get('/buildings/{buildingId}/addinfo/{roomId}/addseat', [ExamRoomInformationController::class, 'addSeat'])->name('addseat');
Route::put('/rooms/{roomId}/update', [ExamRoomInformationController::class, 'updateRoom'])->name('examroominfo.update');
Route::delete('/rooms/{roomId}', [ExamRoomInformationController::class, 'deleteRoom'])->name('rooms.delete');
Route::get('/components/alert', [BuildingController::class, 'alert'])->name('components.alert');

Route::get('/buildings/{buildingId}/room-list/add', [ExamRoomInformationController::class, 'create'])->name('pages.room-create');
Route::post('/buildings/{buildingId}/room-list/store', [ExamRoomInformationController::class, 'store'])->name('examroominfo.store');

Route::delete('/examrooms/{roomId}', [ExamRoomInformationController::class, 'destroy'])->name('examroominfo.destory');
Route::get('/buildings/{buildingId}/room-list/{roomId}', [ExamRoomInformationController::class, 'showRoomDetail'])->name('room-detail');

Route::put('/buildings/{buildingId}/room-list/{roomId}', [ExamRoomInformationController::class, 'saveSelectedSeats'])->name('examroominfo.saveSelectedSeats');
// Route::match(['post', 'put'], '/buildings/{buildingId}/room-list/{roomId}/save-selected-seats', [ExamRoomInformationController::class, 'saveSelectedSeats'])->name('examroominfo.saveSelectedSeats');

// Exam-Manage //
Route::get('/exams', [ExamController::class, 'index'])->name('exam-list');
Route::get('/exams/create', [ExamController::class, 'create'])->name('exam-create');
Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');