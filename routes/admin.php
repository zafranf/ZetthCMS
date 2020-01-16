<?php
Route::middleware('auth')->group(function () {
    Route::middleware('access')->group(function () {

    });
});
