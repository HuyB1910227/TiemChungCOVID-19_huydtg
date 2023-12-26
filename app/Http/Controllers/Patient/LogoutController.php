<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        $request->session()->flush();
        // $request->session()->regenerate();
        return redirect('nguoi-dan/dang-nhap');
    }

  
}
