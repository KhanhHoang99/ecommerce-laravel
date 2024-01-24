<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
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

        $searchQuery = $request->input('search_query');

        // Perform the search logic, for example using Eloquent
        $results = Product::where('name', 'like', '%' . $searchQuery . '%')->get();

        // Pass the cart data to the view
        return view('frontend.search.search', [
            'cart' => $cart, 
            'categories' => $categories
            , 'brands' => $brands
            ,'totalQuantity' => $totalQuantity,
            'results' => $results
        ]);
       

       
        
    }


    public function showSearchAdvanced(Request $request)
    {

        
        $categories = Category::all();
        $brands = Brand::all();

        // Retrieve the cart from the session
        $cart = session()->get('cart', []);

        // get cart from the session
        $cart = session()->get('cart', []);

        // Calculate the total quantity in the cart
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        $name = $request->input('name');
        $price = $request->input('price');

        $id_category = $request->input('id_category');
        $id_brand = $request->input('id_brand');
       

        $query = Product::query();

        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($price !== null && $price != 'Choose Price') {
            $query->where('price', '>=', $price);
        }

        if ($id_category !== null && $id_category != 'Choose Category') {
            $query->where('id_category', $id_category);
        }

        if ($id_brand !== null && $id_brand != 'Choose Brand') {
            $query->where('id_brand', $id_brand);
        }
  
       
        $results = $query->get();

         // Pass the cart data to the view
         return view('frontend.search.search', [
            'cart' => $cart, 
            'categories' => $categories,
            'brands' => $brands,
            'totalQuantity' => $totalQuantity,
            'results' => $results
        ]);
    }

    public function SearchPriceRange(Request $request)
    {
        // get min price and max price
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');

        $products = Product::whereBetween('price', [$minPrice, $maxPrice])->get();

        if($products) {

            return response()->json([
                'message' => 'ok',
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'products' => $products,
            ]);

        }

        return response()->json([
            'message' => 'no product',
            'products' => [],
        ]);

        
    }

}
