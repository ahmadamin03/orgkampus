<?php

namespace App\Http\Middleware;

use App\Traits\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            TenantContext::setOrganizationId(Auth::user()->organization_id);
        }

        return $next($request);
    }
}
