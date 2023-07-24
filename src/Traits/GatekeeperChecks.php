<?php

namespace Kettasoft\Gatekeeper\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;

trait GatekeeperChecks
{
    /**
     * Check if user has a permission by its name.
     *
     * @param string $permission
     * @param bool $requireAll
     */
    public function hasPermission(
        string|array $permission,
        bool $requireAll = false
    ): bool {
        return $this->gatekeeperUserChecker()->currentUserHasPermission(
            $permission,
            $requireAll
        );
    }
}
