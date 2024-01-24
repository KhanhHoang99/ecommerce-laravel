<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index()
    {
        //
        // return view('frontend.login-register');
        
    }

    public function store(UserRegisterRequest $request)
    {
      
        $path = '';

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
        
          
            $fileName = time() . '_' . $file->getClientOriginalExtension();
        
            
            $path = $file->storeAs('upload/user/avatar', $fileName, 'public');
        
           
        }

        $user = User::create([
            'name' =>  $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'level' => $request->input('level'),
            'phone' => $request->input('phone'),
            'id_country' => $request->input('id_country'),
            'level' => 0,
            'avatar' => $path
        ]);
  
        auth()->login($user);
        
        return redirect()->route('userPage'); 

        

    }

}
