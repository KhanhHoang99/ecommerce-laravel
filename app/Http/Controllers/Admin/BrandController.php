<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $brands = Brand::all();
        return view('admin.brand.brand', ['user' => $user, 'brands' => $brands]);
    }


    public function store(Request $request)
    {
        //
        // Validate the form data
        $request->validate([
            'name' => 'required|unique:brands',
        ]);

        Brand::create([
            'name' => $request->input('name'),
        ]);

        return Redirect::back()->with('success', 'Brand created successfully');
    }

    public function destroy($id)
    {
        //
        $category = Brand::find($id);
        $category->delete();
        
        return Redirect::back()->with('success', 'Brand deleted successfully!');
    }
}
