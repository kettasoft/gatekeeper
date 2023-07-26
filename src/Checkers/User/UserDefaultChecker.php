<?php

namespace Kettasoft\Gatekeeper\Checkers\User;

use Illuminate\Support\Arr;
use Kettasoft\Gatekeeper\Traits\GatekeeperCacheing;

class UserDefaultChecker extends UserChecker
{
    use GatekeeperCacheing;

    public function currentUserHasPermission(
        string|array $permission,
        bool $requireAll = false
    ): bool {

        if (is_array($permission)) {
            if (empty($permission)) {
                return true;
            }

            foreach ($permission as $permissionName) {
                $hasPermission = $this->currentUserHasPermission($permissionName);

                if ($hasPermission && ! $requireAll) {
                    return true;
                }

                elseif (! $hasPermission && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found.
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll.
            return $requireAll;
        }

        if (! empty($userCachedPermissions = $this->userCachedPermissions())) {
            if (Arr::get(Arr::get($userCachedPermissions, 'permissions'), $permission)) {
                return true;
            }
        }

        return false;
    }
}
