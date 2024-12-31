<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\BackupTables;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(BackupTables::class)->everyMinute();
// Schedule::command('backup:tables')->everyMinute();
// Schedule::command(BackupTables::class)->weekly();
// Schedule::command(BackupTables::class)->at('00.00')->weekly();
// ->weekends();
// ->sundays();
// ->weekly()->mondays();
// ->daily();
