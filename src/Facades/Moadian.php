<?php

namespace Jooyeshgar\Moadian\Facades;

use Illuminate\Support\Facades\Facade;

class Moadian extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Jooyeshgar\Moadian\Moadian';
    }
}