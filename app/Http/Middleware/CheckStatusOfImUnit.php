<?php

namespace App\Http\Middleware;

use App\Employee;
use App\ImmunizationUnit;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;


class CheckStatusOfImUnit
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
        
        /** @var App\Models\User $user */
        $idIU = Auth::user()->employee->immunization_unit_id;
       
        // $idIU = Employee::find($idE)->immunization_unit_id;
        $iu = ImmunizationUnit::find($idIU);
        if($iu->status == 0)
            return redirect('/ban-quan-ly/ngung-hoat-dong');
        return $next($request);
            
    }
}
