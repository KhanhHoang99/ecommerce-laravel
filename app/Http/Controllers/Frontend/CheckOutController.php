<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    //
    public function show(Request $request)
    {

        $categories = Category::all();
        $brands = Brand::all();

        // Retrieve the cart from the session
        $cart = session()->get('cart', []);

        // get cart from the session
        $cart = session()->get('cart', []);

        // Calculate the total quantity in the cart
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
        }

        // Pass the cart data to the view
        return view('frontend.checkout.checkout', [
            'cart' => $cart, 
            'categories' => $categories, 
            'brands' => $brands,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
       

       
        
    }
}
