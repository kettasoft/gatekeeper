<?php

namespace Kettasoft\Gatekeeper\Validation\Validators;

use Kettasoft\Gatekeeper\Exceptions\PermissionShouldNotHaveMultipleDimensions;
use Kettasoft\Gatekeeper\Validation\GatekeeperValidator;

class CheckPermissionIfNotHaveMultipleDimensions extends GatekeeperValidator
{
    public function validator(): true
    {
        foreach ($this->permissions as $permission) {
            if (is_array($permission)) {
                throw new PermissionShouldNotHaveMultipleDimensions;
            }
        }

        return true;
    }
}
