<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Validator::extend('nrp', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]{6}$/', $value);
        }, 'NRP harus terdiri dari 6 digit angka.');
    }
}
