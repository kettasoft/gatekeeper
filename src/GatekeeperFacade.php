<?php

namespace Kettasoft\Gatekeeper;

use Illuminate\Support\Facades\Facade;

class GatekeeperFacade extends Facade
{
    /**
     * Get the registered name of the component.
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gatekeeper';
    }
}