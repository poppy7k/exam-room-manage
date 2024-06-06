<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buildings/add', function () {
    return view('buildings.addbuilding');
})->name('buildings.addbuilding');

Route::post('/buildings/add', [BuildingController::class, 'store'])->name('buildings.store');

Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');