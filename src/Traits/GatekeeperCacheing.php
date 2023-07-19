<?php

namespace Kettasoft\Gatekeeper\Traits;

use Illuminate\Support\Collection;
use UnexpectedValueException;
use Illuminate\Support\Facades\Cache;

trait GatekeeperCacheing
{
    /**
     * Tries return key name for user_models.
     *
     * @return string|void default key user
     */
    public function userModelCacheKey(): string
    {
        foreach (config('gatekeeper.user_models') as $key => $model) {
            if ($this->user instanceof $model) {
                return $key;
            }
        }

        $modelClass = get_class($this);

        throw new UnexpectedValueException("Class '{$modelClass}' is not defined in the gatekeeper.user_models");
    }
}
