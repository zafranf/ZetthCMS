<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
/* admin routes */
if (env('ADMIN_ROUTE') == 'path') {
    Route::prefix('admin')->group(function () {
        include "admin.php";
    });
} else if (env('ADMIN_ROUTE') == 'subdomain') {
    Route::domain('admin.' . env('APP_DOMAIN'))->group(function () {
        include "admin.php";
    });
}

/* site routes */
Route::get('/', function () {
    return view('welcome');
});

/* authentication routes */
Auth::routes(['verify' => true]);
if (env('APP_DEBUG')) {
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/test', 'TestController@index')->name('test');
}
