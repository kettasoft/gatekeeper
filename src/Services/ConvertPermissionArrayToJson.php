<?php

namespace Kettasoft\Gatekeeper\Services;

use Kettasoft\Gatekeeper\Validation\Validators\CheckPermissionIfNotHaveMultipleDimensions;

class ConvertPermissionArrayToJson
{
    public static function convert(array $permission): string
    {
        if ((new CheckPermissionIfNotHaveMultipleDimensions($permission))->validator())
        {
            return json_encode($permission);
        }
    }
}
