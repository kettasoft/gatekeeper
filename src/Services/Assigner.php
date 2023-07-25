<?php

namespace Kettasoft\Gatekeeper\Services;

use Illuminate\Support\Collection;
use Kettasoft\Gatekeeper\Contracts\AssignerInterface;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;
use Kettasoft\Gatekeeper\Validation\Validators\CheckPermissionIfNotHaveMultipleDimensions;

class Assigner implements AssignerInterface
{
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
    public function currentUserGivePermission(string|array $permission): true
    {

        $permission = $this->setDefaultValueToPermission($permission);

        if ($this->user->permissions->isEmpty()) {
            $this->user->permissions()->create(['permissions' => $permission]);
            return true;
        }

        $newPermissions = array_values($this->allPermissions()->add($permission)->flatten()->unique()->toArray());

        $this->user->permissions()->update(['permissions' => $newPermissions]);

        return true;
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
