<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\RouteHelper;
use App\Http\Controllers\Superadmin\StudentController;

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
    RouteHelper::make('student', StudentController::class, 'student');
});
