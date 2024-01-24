<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $categories = Category::all();
        return view('admin.category.category', ['user' => $user, 'categories' => $categories]);
    }


    public function store(Request $request)
    {
        //
        // Validate the form data
        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        Category::create([
            'name' => $request->input('name'),
        ]);

        return Redirect::back()->with('success', 'Category created successfully');
    }

    public function destroy($id)
    {
        //
        $category = Category::find($id);
        $category->delete();
        
        return Redirect::back()->with('success', 'category deleted successfully!');
    }
}
