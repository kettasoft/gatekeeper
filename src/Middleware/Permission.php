<?php

namespace Kettasoft\Gatekeeper\Middleware;

use Closure;
use Illuminate\Http\Request;

class Permission extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request source request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string|array $permission
     */
    public function handle(Request $request, Closure $next, string|array $permissions, ?string $options = null)
    {
        if (! $this->authorization('permissions', $permissions, $options)) {
            return $this->unauthorized();
        }
        
        return $next($request);
    }
}