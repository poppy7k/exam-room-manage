<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ExamRoomInformationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buildings/add', function () {
    return view('buildings.addbuilding');
})->name('buildings.addbuilding');

Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
Route::post('/buildings/store', [BuildingController::class, 'store'])->name('buildings.store');
Route::get('/buildings/{buildingId}/addinfo', function($buildingId) {
    return view('buildings.addinfo', ['buildingId' => $buildingId]);
})->name('buildings.addinfo');

Route::get('/buildings/{buildingId}/exam-room-info/create', [ExamRoomInformationController::class, 'create'])->name('examroominfo.create');
Route::post('/exam-room-info/store', [ExamRoomInformationController::class, 'store'])->name('examroominfo.store');