<?php

namespace MFrouh\Sms4jawaly\Sms4JawalyServiceProvider;

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
        $this->app->bind('Sms4jawaly', function ($app) {
            return new BaseClass();
        });
    }

    public function boot()
    {

    }
}