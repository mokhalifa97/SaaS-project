<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantDatabaseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $request->getHost();
        if ($subdomain && $subdomain != 'saas-project.test') {
            $tenant = Tenant::where('subdomain', $subdomain)->first();
            if ($tenant) {
                (new TenantDatabaseService())->connectToDb($tenant);
                (new TenantDatabaseService())->migrateToDb($tenant);
            }else{
                abort(404);
            }
        }

        return $next($request);
    }
}
