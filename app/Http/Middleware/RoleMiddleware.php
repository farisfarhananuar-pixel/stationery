<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized.');
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been suspended.');
        }

        // Seller must be approved
        if (Auth::user()->role === 'seller') {
            $profile = Auth::user()->sellerProfile;
            if ($profile && $profile->status === 'pending' && !$request->routeIs('seller.pending')) {
                return redirect()->route('seller.pending');
            }
        }

        return $next($request);
    }
}
