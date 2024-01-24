<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //
    public function index()
    {
       
        $user = auth()->user();
        $countries = Country::all();

        return view('frontend.account', ['user' => $user,'countries' => $countries]);
        
    }
}
