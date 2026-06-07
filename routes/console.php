<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| ARTISAN COMMANDS
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {

    $this->comment(Inspiring::quote());

})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| OVERDUE BORROW CHECKER
|--------------------------------------------------------------------------
*/

Schedule::command('borrows:overdue')
    ->everyMinute();