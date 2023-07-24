<?php

namespace Kettasoft\Gatekeeper\Exceptions;

class PermissionShouldNotHaveMultipleDimensions extends \Exception
{
    public function __construct()
    {
        parent::__construct('Permission should not have multiple dimensions.');
    }
}
