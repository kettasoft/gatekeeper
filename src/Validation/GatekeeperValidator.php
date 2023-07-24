<?php

namespace Kettasoft\Gatekeeper\Validation;

abstract class GatekeeperValidator
{
    /**
     * Undocumented function
     *
     * @param array $permissions
     */
    public function __construct(protected array $permissions)
    {
    }

    /**
     * Validator handling method.
     *
     * @return true
     */
    abstract public function validator(): true;
}
