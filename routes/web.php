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
    return redirect('login');
});

/* authentication routes */
Auth::routes();
if (env('APP_DEBUG')) {
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/test', 'TestController@index');
}

/* application routes */
Route::middleware('auth')->group(function (){
    /* api */
    Route::get('/setting/menus/data', 'Setting\MenuController@index');
    Route::get('/setting/roles/data', 'Setting\RoleController@index');
    Route::get('/setting/users/data', 'Setting\UserController@index');

    Route::get('/setting/menus/sort', 'Setting\MenuController@sort')->name('menus.sort');
    Route::put('/setting/menus/sort', 'Setting\MenuController@sortSave');

    Route::middleware('access')->group(function (){
        /* dashboard */
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

        /* module setting routes */
        Route::prefix('setting')->group(function () {
            Route::resources([
                '/application' => 'Setting\ApplicationController',
                '/menus' => 'Setting\MenuController',
                '/roles' => 'Setting\RoleController',
                '/users' => 'Setting\UserController',
            ]);
        });
        
    });
});