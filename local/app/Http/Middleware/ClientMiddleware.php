<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware {




    public function handle($request, Closure $next) {

        if (Auth::user()->hasPermissionTo('Administer roles & permissions')) {
            return $next($request);
        }

        if ($request->is('sample/create')) {
            if (!Auth::user()->hasPermissionTo('Create Sample')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('client/create')) {
            if (!Auth::user()->hasPermissionTo('Create Client')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->is('client')) {
            if (!Auth::user()->hasPermissionTo('View Client')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('sample')) {
            if (!Auth::user()->hasPermissionTo('View Sample')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->is('posts/*/edit')) {
            if (!Auth::user()->hasPermissionTo('Edit Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('edit/sample/*/*')) {
            if (!Auth::user()->hasPermissionTo('Edit Sample')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('delete/sample/*')) {
            if (!Auth::user()->hasPermissionTo('Delete Sample')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->isMethod('Delete')) {
            if (!Auth::user()->hasPermissionTo('Delete Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        return $next($request);
    }
}
