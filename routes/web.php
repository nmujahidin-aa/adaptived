<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DashboardController;


Route::group(['namespace'=>'App\Http\Controllers', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});