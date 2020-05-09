<?php
/**
 * Additional Admin Routes
 * Prefix: based on adminPath()
 * Middleware: web
 */
Route::middleware('auth')->group(function () {
    //

    Route::middleware('access')->group(function () {
        //
    });
});
