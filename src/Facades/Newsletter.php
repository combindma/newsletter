<?php

namespace Combindma\Newsletter\Facades;

use Illuminate\Support\Facades\Facade;

class Newsletter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'newsletter';
    }
}
