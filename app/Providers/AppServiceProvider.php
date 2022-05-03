<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if ($this->app->runningUnitTests()) {
            Schema::defaultStringLength(191);
        // }
        Validator::extend('decimal', function ($attribute, $value, $parameters, $validator) {
            $decimalLength = strlen(strrchr(strval($value), '.')) - 1;
            if($decimalLength > intval($parameters[0])) 
                return false;
            else 
                return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing') && class_exists(DuskServiceProvider::class)) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
