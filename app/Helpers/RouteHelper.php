<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class RouteHelper
{
    public static function make($prefix, $controllerClass, $routeName)
    {
        Route::prefix($prefix)
            ->controller($controllerClass)
            ->name($routeName . '.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/edit/{id?}', 'edit')->name('edit');
                Route::post('/store', 'store')->name('store');
                Route::delete('/delete', 'destroy')->name('destroy');
                Route::delete('/delete/{id}', 'single_destroy')->name('single_destroy');
            });
    }
}
