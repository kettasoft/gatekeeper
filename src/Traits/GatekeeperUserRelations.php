<?php

namespace Kettasoft\Gatekeeper\Traits;

use Illuminate\Support\Facades\Config;
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
            Config::get('gatekeeper.models.permission'),
            'user',
            Config::get('gatekeeper.tables.permission_user')
        )->as('user')->withPivot('status');
    }

    /**
     * Many-to-Many relations with role.
     */
    public function roles(): MorphToMany
    {
        return $this->morphToMany(
            Config::get('gatekeeper.models.role'),
            'user',
            Config::get('gatekeeper.tables.role_user'),
        );
    }
}
