<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        //
        $newestProducts = Product::orderBy('created_at', 'desc')->take(6)->get();
        $categories = Category::all();
        $brands = Brand::all();

         // get cart from the session
         $cart = session()->get('cart', []);

         // Calculate the total quantity in the cart
         $totalQuantity = array_sum(array_column($cart, 'quantity'));

        return view('frontend.user-page', ['newestProducts' => $newestProducts, 
        'categories' => $categories
        , 'brands' => $brands,
        'cart' => $cart,
        'totalQuantity' => $totalQuantity
    ]);
        
    }
}
