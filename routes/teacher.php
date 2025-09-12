<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\RouteHelper;
use App\Http\Controllers\Teacher\AssesmentController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\LearningResourceController;
use App\Http\Controllers\Teacher\GroupController;
use App\Http\Controllers\Teacher\WorksheetController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Route ini telah didaftarkan dalam **RouteServiceProvider** dengan konfigurasi khusus sebagai berikut:
| - **Prefix**: `superadmin`
| - **As**: `superadmin.`
| - **Namespace**: `Admin`
|
| Route ini mengarahkan langsung ke Controller yang berada di dalam folder **Admin**.
| Dengan menggunakan pengaturan ini, semua route yang didefinisikan akan otomatis memiliki prefix `superadmin` dan dapat diakses dengan nama alias yang dimulai dengan `superadmin.`
| Contohnya, `admin.index` akan merujuk pada method `index` dalam Controller yang sesuai di namespace **Admin**.
| Pengaturan ini memudahkan pengelolaan dan akses route secara terstruktur dalam aplikasi Anda.
|
*/


Route::group(["middleware"=>"auth"], function(){
    RouteHelper::make('assesment', AssesmentController::class, 'assesment');
    RouteHelper::make('student', StudentController::class, 'student');
    RouteHelper::make('learning-resource', LearningResourceController::class, 'learning-resource');
    RouteHelper::make('worksheet', WorksheetController::class, 'worksheet');
    RouteHelper::make('group', GroupController::class, 'group');

    Route::group(['prefix' => 'assesment/{variable_id}', 'as' => 'assesment.'], function () {
        RouteHelper::make('question', QuestionController::class, 'question');
    });
});
