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
Route::get('/', function () {
    return view('welcome');
});

/* authentication routes */
Auth::routes();
if (env('APP_DEBUG')) {
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/test', 'TestController@index');
}

/* admin routes */
Route::prefix('admin')->group(function (){
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LoginController@logout');
    if (env('APP_DEBUG')) {
        Route::get('/logout', 'Auth\LoginController@logout');
    }
});
Route::prefix('admin')->middleware('auth')->group(function (){
    /* api */
    Route::get('/setting/menus/data', 'Admin\Setting\MenuController@datatable');
    Route::get('/setting/roles/data', 'Admin\Setting\RoleController@datatable');
    Route::get('/setting/users/data', 'Admin\Setting\UserController@datatable');

    /* sort menu */
    Route::get('/setting/menus/sort', 'Admin\Setting\MenuController@sort')->name('menus.sort');
    Route::put('/setting/menus/sort', 'Admin\Setting\MenuController@sortSave');

    Route::middleware('access')->group(function (){
        /* dashboard */
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard.index');

        /* module setting routes */
        Route::prefix('setting')->group(function () {
            Route::resources([
                '/application' => 'Admin\Setting\ApplicationController',
                '/menus' => 'Admin\Setting\MenuController',
                '/roles' => 'Admin\Setting\RoleController',
                '/users' => 'Admin\Setting\UserController',
            ]);
        });
        
    });
});