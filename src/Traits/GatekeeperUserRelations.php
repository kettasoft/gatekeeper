<?php

namespace Kettasoft\Gatekeeper\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait GatekeeperUserRelations
{
    /**
     * Many-to-Many relations with Permission.
     *
     * @return MorphToMany
     */
    public function permissions(): MorphToMany
    {
        return $this->morphToMany(
            config('gatekeeper.models.permission'),
            'user',
            config('gatekeeper.tables.permission_user')
        )->as('user')->withPivot('status');
    }

    /**
     * Many-to-Many relations with role.
     */
    public function roles(): MorphToMany
    {
        return $this->morphToMany(
            config('gatekeeper.models.role'),
            'user',
            config('gatekeeper.tables.role_user'),
        );
    }
}
