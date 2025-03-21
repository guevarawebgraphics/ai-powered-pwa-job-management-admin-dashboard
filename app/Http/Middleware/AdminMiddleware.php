<?php

namespace App\Http\Middleware;

use App\Notifications\SendOtpNotification;
use App\Models\User;
use Closure;

/**
 * Class AdminMiddleware
 * @package App\Http\Middleware
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = NULL)
    {

        // Authentication check
        if (!auth()->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/admin/login');
            }
        }

        // Role check
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
            abort('401', '401');
        }

        // IP check
        $ip = request()->header('X-Forwarded-For') ?? request()->ip();
        $user = User::find(auth()->user()->id);

        if ($user->current_ip != $ip || !$user->current_ip) {
            abort('403', '403');
        }

        return $next($request);
    }

}