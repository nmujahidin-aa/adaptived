<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Student\AssesmentController;



Route::group(['namespace'=>'App\Http\Controllers', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::group(["prefix"=>"assesment"], function () {
        Route::get('/', [AssesmentController::class, 'index'])->name('assesment.index');
        Route::get('/{assesment}/questions', [AssesmentController::class, 'questionsIndex'])
            ->name('assesment.questions.index');
    });
});
