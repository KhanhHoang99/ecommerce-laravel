<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Rate;
use Illuminate\Http\Request;

class UserBlogController extends Controller
{
    //
    public function index()
    {
        //
        // $user = Auth::user();
        // $blogs = Blog::all();
        $blogs = Blog::paginate(3);
        // $blogs = Blog::latest()->paginate(3);

        $categories = Category::all();
        $brands = Brand::all();

       
        
        return view('frontend.blog.blog-list', 
            ['blogs' => $blogs,  
            'categories' => $categories, 
            'brands' => $brands,
            ]
        );
        
    }

    public function show($id)
    {
        //

        // $blogPrev = (int)$id - 1;
        // $blogNext = (int)$id + 1;

        $total = Blog::count();

        // get id of blog
        $previous = Blog::where('id', '<', $id)->max('id');
        $next = Blog::where('id', '>', $id)->min('id');
        
        $blog = Blog::findOrFail($id);


        $rates = Rate::where('id_blog', $id)->get();
        $comments = BlogComment::where('id_blog', $id)->get();

        $categories = Category::all();
        $brands = Brand::all();
        

        // tính trung bình rate
        $averageRate = $rates->avg('rate');


        return view('frontend.blog.blog-detail', ['blog' => $blog, 
            'rates' => $rates, 
            'averageRate' => round($averageRate), 
            'comments' => $comments,
            'total' => $total,
            'previous' => $previous,
            'next' => $next,
            'categories' => $categories
            , 'brands' => $brands

        ]);
    }

    public function comment(Request $request)
    {
        $request->validate([
            'id_blog' => 'required|exists:blogs,id',
            'level' => 'required',
            'comment' => 'required',
            'name' => 'required',
            'avatar' => 'required',
            
        ]);

        $user = auth()->user();

        BlogComment::create([
            'comment' => $request->comment,
            'id_blog' => $request->id_blog,
            'id_user' => $user->id,
            'name' => $request->name,
            'avatar' => $request->avatar,
            'level' =>   (int)$request->level
        ]);

        
        return redirect()->back();
        
    }
}
