<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'menu.access'])->group(function () {
    // put your custom route here

    if (file_exists(__DIR__ . '/modules.php')) {
        require __DIR__ . '/modules.php';
    }
});