<?php

namespace Tapp\BladeUppy;

use Illuminate\Support\Facades\Facade;

class BladeUppyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'blade-uppy';
    }
}
