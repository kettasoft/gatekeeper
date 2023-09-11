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
        $permissions = $this->setDefaultValueToPermissionKeys($permission);

        $data = $this->user->permissions()->firstOr(function () use($permissions) {
            $this->user->permissions()->create(['permissions' => $permissions]);
            return $this->user;
        });
        
        if ($data instanceof GatekeeperInterface) {
            return $this->user;
        }

        $newPermissions = array_merge($data->permissions, $permissions);

        if ($data->permissions !== $newPermissions) {
            $this->user->permissions()->update(['permissions' => $newPermissions]);
        }
        return $this->user;
    }

    public function currentUserRemovePermission(array|string $permission): GatekeeperInterface
    {
        $cachedPermissions = $this->userCachedPermissions();

        if ($cachedPermissions) {

            $newPermissions = collect(Arr::get($cachedPermissions, 'permissions'))->forget($permission);

            if ($newPermissions->isEmpty()) {
                $this->user->permissions()->delete();
                return $this->user;
            }

            $this->user->permissions()->update(['permissions' => $newPermissions]);
            return $this->user;
        }

        return $this->user;
    }

    /**
     * Add a default value to all elements of the array
     *
     * @param array $permissions
     * @param boolean $default
     * @return array
     */
    private function setDefaultValueToPermissionKeys(array|string $permissions, $default = true): array
    {
        $permissions = is_array($permissions) ? $permissions : [$permissions];
        $result = [];
        foreach($permissions as $permission) {
            if (! is_string($permission)) return $permissions;
            $result[$permission] = $default;
        }

        return $result;
    }
}
