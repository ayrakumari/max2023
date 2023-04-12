<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Carbon\Carbon;
class SessionTimeout
{
  public function handle($request, Closure $next)
  {

    // If user is not logged in...
    if (!Auth::check()) {
      return $next($request);
    }

    $user = Auth::guard()->user();

    $now = Carbon::now();

    $last_seen = Carbon::parse($user->last_activetime);

    $absence = $now->diffInMinutes($last_seen);

     $tm=120;
    // If user has been inactivity longer than the allowed inactivity period
    // if ($absence > config('session.lifetime')) {
        if ($absence > $tm) {
      Auth::guard()->logout();

      $request->session()->invalidate();

      return $next($request);
    }

    $user->last_activetime = $now->format('Y-m-d H:i:s');
    $user->save();

    return $next($request);
  }
}
