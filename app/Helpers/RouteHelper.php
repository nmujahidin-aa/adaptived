<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class RouteHelper
{
    public static function make($prefix, $controller, $name) {
        Route::prefix($prefix)->controller($controller)->name($name . '.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id?}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete', 'destroy')->name('destroy');
            Route::delete('/delete/{id}', 'single_destroy')->name('single_destroy');
        });
    }
}
