<?php

namespace InfusionWeb\Laravel\Marketo;

use Illuminate\Support\Facades\Facade;

class MarketoClientFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'marketo';
    }
}
