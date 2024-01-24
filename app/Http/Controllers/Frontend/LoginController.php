<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function index()
    {
        $countries = Country::all();
        //
        return view('frontend.login-register',['countries' => $countries]);
        
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->route('userPage'); 
        }
    
        // Authentication failed
        return back()->with('error', 'Invalid login credentials');
    }
}
