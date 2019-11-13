<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ViewerCounterFacade extends Facade
{

    /**
     * getFacadeAccessor
     *
     * @method static int count(String $id)
     */
    public static function getFacadeAccessor()
    {
        return 'App\Contracts\ViewerCounterContract';
    }
}
