<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
})->name('home');
Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
