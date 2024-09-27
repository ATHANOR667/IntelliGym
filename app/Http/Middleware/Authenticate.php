<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {

        if ($request->expectsJson() ){
            return null ;
        }
        if (Auth::guard('admin')->check() === false) {
            return route('admin.login');  // Rediriger vers la page de login des admins
        }
        return null ;
    }
   /* protected function redirectTo(Request $request): ?string
    {

        if ($request->is('/*')) {
            if (Auth::guard('admin')->check() === false) {
                return redirect(to_route('admin.login'));  // Rediriger vers la page de login des admins
            }
        }

        // Par défaut, on ne redirige pas dans les autres cas (par exemple, pour les API avec Sanctum)
        return null;
    }*/
}
