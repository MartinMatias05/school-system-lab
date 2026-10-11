<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('school:about', function () {
    $this->info('School System Lab: students, courses, activities, and submissions.');
})->purpose('Display information about this lab application.');
