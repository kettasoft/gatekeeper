<?php

namespace Kettasoft\Gatekeeper\Traits;

use UnexpectedValueException;
use Illuminate\Support\Facades\Cache;

trait GatekeeperCacheing
{
    /**
     * Tries to return all the cached roles of the user.
     * If it can't bring the roles from the cache,
     * it brings them back from the DB.
     */
    protected function userCachedRoles(): array
    {
        $cacheKey = 'gatekeeper_roles_for_' . $this->userModelCacheKey() . '_' . $this->user->getKey();

        if (!config('gatekeeper.cache.enabled')) {
            return $this->user->roles()->get()->toArray();
        }

        return Cache::remember($cacheKey, config('gatekeeper.cache.expiration_time', 60), function () {
            return $this->user->roles()->get()->toArray();
        });
    }

    /**
     * Tries to return all the cached permissions of the user
     * and if it can't bring the permissions from the cache,
     * it brings them back from the DB.
     */
    public function userCachedPermissions(): array
    {
        $cacheKey = 'gatekeeper_permissions_for_' . $this->userModelCacheKey() . '_' . $this->user->getKey();

        $permissions = $this->user->permissions->first()->toArray();

        if (!config('gatekeeper.cache.enabled')) {
            return $permissions;
        }

        return Cache::remember($cacheKey, config('gatekeeper.cache.expiration_time', 60), function () use ($permissions) {
            return $permissions;
        });
    }

    /**
     * Flush the current user permissions and roles from the cache
     *
     * @return void
     */
    public function currentUserFlushCache(): void
    {
        Cache::forget('gatekeeper_roles_for_' . $this->userModelCacheKey() . '_' . $this->user->getKey());
        Cache::forget('gatekeeper_permissions_for_' . $this->userModelCacheKey() . '_' . $this->user->getKey());
    }

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
