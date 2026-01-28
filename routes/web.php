<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Student\AssesmentController;
use App\Http\Controllers\Student\LearningResourceController;
use App\Http\Controllers\Student\WorksheetController;
use App\Http\Controllers\Student\GuideController;



Route::group(['namespace'=>'App\Http\Controllers', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::group(['namespace' => 'Student'], function () {
        Route::group(['prefix' => 'guide', 'as' => 'guide.'], function () {
            Route::get('/', [GuideController::class, 'index'])->name('index');
            Route::get('/show/{id}', [GuideController::class, 'show'])->name('show');
        });

        Route::group(['prefix' => 'learning-resource', 'as' => 'learning-resource.'], function () {
            Route::get('/', [LearningResourceController::class, 'index'])->name('index');
            Route::get('/show/{id}', [LearningResourceController::class, 'show'])->name('show');
        });

        Route::group(['prefix' => 'worksheet', 'as' => 'worksheet.'], function () {
            Route::get('/', [WorksheetController::class, 'index'])->name('index');
            Route::get('/show/{worksheet_id}/{group_id}', [WorksheetController::class, 'show'])->name('show');

            Route::post('/answer/store/{id}', [WorksheetController::class, 'store'])->name('answer.store');
        });

    });


    Route::group(['prefix' => 'assesment', 'as' => 'assesment.'], function () {
        Route::get('/', [AssesmentController::class, 'index'])->name('index');
        Route::get('/show/{id}', [AssesmentController::class, 'show'])->name('show');

        Route::post('/answer/store/{id}', [AssesmentController::class, 'store'])->name('answer.store');
    });
});
