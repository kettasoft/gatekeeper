<?php

namespace Kettasoft\Gatekeeper\Services;

use Illuminate\Support\Collection;
use Kettasoft\Gatekeeper\Contracts\AssignerInterface;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;
use Kettasoft\Gatekeeper\Traits\GatekeeperCacheing;
use Illuminate\Support\Arr;

class Assigner implements AssignerInterface
{

    use GatekeeperCacheing;

    public function __construct(protected GatekeeperInterface $user)
    {
    }

    protected function allPermissions(): Collection
    {
        return $this->user->permissions->pluck('permissions')->collapse();
    }

    /**
     * Give permission to user.
     *
     * @param string|array $permission
     * @return GatekeeperInterface
     */
    public function currentUserGivePermission(string|array $permission): GatekeeperInterface
    {
        $permission = $this->setDefaultValueToPermission($permission);
        $userCachedPermissions = collect($this->userCachedPermissions())->get('permissions');

        if (is_null($userCachedPermissions)) {
            $this->user->permissions()->create(['permissions' => $permission]);
            return $this->user;
        }

        $newPermissions = array_merge($userCachedPermissions, $permission);

        $this->user->permissions()->update(['permissions' => $newPermissions]);

        return $this->user;
    }

    public function currentUserRemovePermission(array|string $permission): GatekeeperInterface
    {
        if ($cachedPermissions = $this->userCachedPermissions()) {
            $newPermissions = collect(Arr::get($cachedPermissions, 'permissions'))->forget($permission);

            if ($newPermissions->isEmpty()) {
                $this->user->permissions()->delete();
            }

            $this->user->permissions()->update(['permissions' => $newPermissions]);
        }

        return $this->user;
    }

    private function setDefaultValueToPermission(array $permissions, $default = true)
    {
        $result = [];

        foreach($permissions as $permission) {
            $result[$permission] = $default;
        }

        return $result;
    }
}
