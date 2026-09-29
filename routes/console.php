<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
require __DIR__ . '/../vendor/solaris/solaris-laravel-core/routes/console.php';
require __DIR__ . '/../vendor/solaris/solaris-laravel-masterdata/routes/console.php';
require __DIR__ . '/../vendor/solaris/solaris-laravel-basecrm/routes/console.php';
require __DIR__ . '/../vendor/solaris/solaris-laravel-sales/routes/console.php';
require __DIR__ . '/../vendor/solaris/solaris-laravel-marketing/routes/console.php';
require __DIR__ . '/../vendor/solaris/solaris-laravel-crm/routes/console.php';
