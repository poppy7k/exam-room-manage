<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;

Route::get('/', function () {
    return view('pages.building-list');
});

Route::get('/buildings/add', function () {
    return view('buildings.addbuilding');
})->name('buildings.addbuilding');

Route::post('/buildings/add', [BuildingController::class, 'store'])->name('buildings.store');

Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
Route::get('/building-list', [BuildingController::class, 'index'])->name('pages.building-list');
