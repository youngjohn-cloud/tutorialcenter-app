<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//scheduling "deleting unverified guardians and students" task to run every 1 hour
app(Schedule::class)->command('app:delete-unverified-users')->hourly();
