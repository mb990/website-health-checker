<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            'D:\xampp\htdocs\website-health-checker\vendor\laravel\framework\src\Illuminate\Notifications\resources\views' => public_path('vendor/email-views'),
        ], 'public');
    }
}
