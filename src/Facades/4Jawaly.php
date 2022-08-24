<?php

namespace MFrouh\Sms4jawaly\Facades;

use Illuminate\Support\Facades\Facade;

class Sms4jawaly extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Sms4jawaly';
    }
}

