<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ExamRoomInformationController;

Route::get('/', function () {
    return view('pages.building-list');
})->name('home');

Route::get('/', [BuildingController::class, 'building_list'])->name('building-list');
Route::get('/buildings/add', [BuildingController::class, 'create'])->name('pages.building-create');

Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
Route::post('/buildings/store', [BuildingController::class, 'store'])->name('buildings.store');
Route::get('/buildings/{buildingId}/addinfo', function($buildingId) {
    return view('buildings.addinfo', ['buildingId' => $buildingId]);
})->name('buildings.addinfo');

Route::get('/buildings/{buildingId}/exam-room-info/create', [ExamRoomInformationController::class, 'create'])->name('examroominfo.create');
Route::post('/exam-room-info/store', [ExamRoomInformationController::class, 'store'])->name('examroominfo.store');

Route::delete('/buildings/{buildingId}', [BuildingController::class, 'destroy'])->name('buildings.destroy');

Route::get('/buildings/{buildingId}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
Route::put('/buildings/{buildingId}', [BuildingController::class, 'update'])->name('buildings.update');


Route::get('/buildings/{buildingId}/addinfo', [ExamRoomInformationController::class, 'create'])->name('buildings.addinfo');
Route::post('/examroominfo/store', [ExamRoomInformationController::class, 'store'])->name('examroominfo.store');

Route::put('/buildings/{buildingId}/ajax', [BuildingController::class, 'updateAjax'])->name('buildings.updateAjax');

Route::get('/buildings/{buildingId}/room-list', [BuildingController::class, 'showRoomList'])->name('pages.room-list');
