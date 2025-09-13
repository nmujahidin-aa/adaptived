<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Student\AssesmentController;
use App\Http\Controllers\Student\LearningResourceController;



Route::group(['namespace'=>'App\Http\Controllers', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::group(['namespace' => 'Student'], function () {
        Route::group(['prefix' => 'learning-resource', 'as' => 'learning-resource.'], function () {
            Route::get('/', [LearningResourceController::class, 'index'])->name('index');
            Route::get('/show/{id}', [LearningResourceController::class, 'show'])->name('show');
        });
    });
    Route::group(['prefix' => 'assesment', 'as' => 'assesment.'], function () {
        Route::get('/', [AssesmentController::class, 'index'])->name('index');
        Route::get('/show/{id}', [AssesmentController::class, 'show'])->name('show');
    });
});
