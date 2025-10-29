<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::command('click:reset')->dailyAt('12:25');
Schedule::call(function () {
    Artisan::call('click:reset');
})->dailyAt('12:35');
