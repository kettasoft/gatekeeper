<?php

namespace Kettasoft\Gatekeeper\Traits;

use Illuminate\Database\Eloquent\Model;

trait GatekeeperAssigner
{
    /**
     * Add direct permissions to the user.
     */
    public function givePermission(
        array|Model $permission,
    ): static {
        $this->permissions()->create(['permissions' => json_encode($permission)]);

        return $this;
    }
}
