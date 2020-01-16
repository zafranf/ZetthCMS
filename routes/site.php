<?php
/* Site Routes */
Route::name('web.')->middleware(['site'])->group(function () {
    /* Log all visits */
    Route::middleware(['visitor_log'])->group(function () {

    });
});
