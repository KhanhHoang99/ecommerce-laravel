<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //

    function listBlog() {

        
        
        $blogs = Blog::paginate(3);

        return response()->json([
            'status' => 200,
            'data' => $blogs
        ]);
    }
}
