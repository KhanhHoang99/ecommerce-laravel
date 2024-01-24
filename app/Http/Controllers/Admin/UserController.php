<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // tìm user bằng id rồi truyền qua view

         $user = Auth::user();
         $countries = Country::all();
        //
        return view('admin.user.page-profile', ['user' => $user, 'countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateProfileRequest $request)
    {
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        //
         $user = User::findOrFail($id);
 
         $data = $request->all();
         $file = $request->avatar;
         
         
        if($request->hasFile('avatar')){
             $data['avatar'] = $file->getClientOriginalName();
         }else{
            $data['avatar'] =  $user->avatar;
         }
 
         $data['password'] = $data['password'] ? bcrypt($data['password']) : $user->password;

 
         if($user->update($data)) {
 
            if ($request->hasFile('avatar')) {

                // Delete the old avatar if it exists
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                $path = $file->storeAs('upload/user/avatar', $file->getClientOriginalName(), 'public');
                $data['avatar'] = $path;
            }
 
             return redirect()->back()->with('success', 'Updated profile successfully!');
             
         }else{
 
             return redirect()->back()->withErrors('Updated profile error!');
         }
 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
