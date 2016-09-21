<?php

namespace aharen\Language\Facades;

use Illuminate\Support\Facades\Facade;

class Language extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'aharen\Language\Language';
    }
}
