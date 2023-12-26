<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $requestRoles)
    {
       

      /** @var App\Models\User $user */
        $user = Auth::user();
       
        $roles = explode("|", $requestRoles); // convert $roles to array
       
            if($roles === null){
                return redirect('/login');
            }
            if($user->checkAuthorizeRoles($roles) == null)
                return redirect()->route('not-permission')->with('roles', $roles);
            return $next($request);

    }
}
