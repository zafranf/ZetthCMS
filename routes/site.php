<?php
/* Site Routes */
Route::middleware(['site'])->group(function () {
    /* Log all visits */
    Route::middleware(['visitor_log'])->group(function () {

    });
});
