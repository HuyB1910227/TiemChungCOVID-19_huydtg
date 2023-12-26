<?php

// namespace App\Http\Controllers\Patient;

// use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
// // use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class HomeController extends Controller
// {
//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     // public function __construct()
//     // {
//     //     // $this->middleware('auth');
//     // }

//     /**
//      * Show the application dashboard.
//      *
//      * @return \Illuminate\Contracts\Support\Renderable
//      */
//     public function index()
//     {
//         // return view('patient.home');
//         return "hi";

//     }



// }


namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('patient.home');
        // return "hi";

    }
}
