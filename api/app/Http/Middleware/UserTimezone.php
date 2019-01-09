<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class UserTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Config::set('app.user.timezone', $request->header('User-Timezone', Config::get('app.timezone')));

        return $next($request);
    }
}
