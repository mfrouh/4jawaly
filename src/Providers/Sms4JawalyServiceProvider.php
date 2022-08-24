<?php

namespace MFrouh\Sms4jawaly\Providers;

use MFrouh\Sms4jawaly\BaseClass;
use Illuminate\Support\ServiceProvider;

class Sms4JawalyServiceProvider extends ServiceProvider
{

     /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sms4jawaly.php', 'sms4jawaly');

        $this->app->bind('Sms4jawaly', function ($app) {
            return new BaseClass();
        });
    }

    public function boot()
    {

    }
}