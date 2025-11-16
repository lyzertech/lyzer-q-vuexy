<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DataController;
use App\Http\Controllers\school\SchoolStudent;

Route::get('/v1/data/latest', [DataController::class, 'latest']);
Route::get('/v1/voltage/today', [DataController::class, 'getTodayVoltage']);
Route::get('/v1/data', [DataController::class, 'getData']);

Route::get('/students/{class}', [SchoolStudent::class, 'getByClass']);
