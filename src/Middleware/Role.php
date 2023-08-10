<?php

namespace Kettasoft\Gatekeeper\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request source request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string|array $roles
     */
    public function handle(Request $request, Closure $next, string|array $roles, ?string $options = null)
    {
        if (! $this->authorization('roles', $roles, $options)) {
            return $this->unauthorized();
        }
        
        return $next($request);
    }
}