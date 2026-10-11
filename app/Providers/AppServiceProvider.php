<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register application bindings here when needed.
    }

    public function boot(): void
    {
        // Register view composers or other boot-time behavior here when needed.
    }
}
