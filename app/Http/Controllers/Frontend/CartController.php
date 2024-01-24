<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //

    private function findProductIndexInCart($productId, $cart)
    {
        foreach ($cart as $index => $item) {
            if ($item['id'] == $productId) {
                return $index;
            }
        }

        return false;
    }

    public function addCartToSession(Request $request)
    {
        //

        $id = $request->product_id;

        // Get the current cart from the session or create a new one
        $cart = session()->get('cart', []);

        $index = $this->findProductIndexInCart($id, $cart);

        if ($index !== false) {
            // If the product is in the cart, increment the quantity
            $cart[$index]['quantity'] += 1;
        } else {
            // If the product is not in the cart, add it with quantity 1
            $product = Product::find($id);
            $cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'images' => $product->images,
                'quantity' => 1,
            ];
        }

        // Store the updated cart in the session
        session()->put('cart', $cart);
       

       
        
    }


    public function up(Request $request)
    {
        //

        $id = $request->product_id;

        // Get the current cart from the session or create a new one
        $cart = session()->get('cart', []);

        $index = $this->findProductIndexInCart($id, $cart);

        if ($index !== false) {
            // If the product is in the cart, increment the quantity
            $cart[$index]['quantity'] += 1;
        } 

        // Store the updated cart in the session
        session()->put('cart', $cart);
       
        
    }

    public function down(Request $request)
    {
        //

        $id = $request->product_id;

        // Get the current cart from the session or create a new one
        $cart = session()->get('cart', []);

        $index = $this->findProductIndexInCart($id, $cart);

        if ($index !== false) {
            // If the product is in the cart, increment the quantity
            if( $cart[$index]['quantity'] > 1){
                $cart[$index]['quantity'] -= 1;
            }
        } 

        // Store the updated cart in the session
        session()->put('cart', $cart);
       
        
    }

    public function delete(Request $request)
    {
        $productId = $request->product_id;

        // Get the current cart from the session or create a new one
        $cart = session()->get('cart', []);

        // Find the index of the product in the cart
        $index = $this->findProductIndexInCart($productId, $cart);

        if ($index !== false) {
            // If the product is in the cart, remove it
            array_splice($cart, $index, 1);
        }

        // Store the updated cart in the session
        session()->put('cart', $cart);
       
        
    }

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
        return view('frontend.cart.cart', [
            'cart' => $cart, 
            'categories' => $categories, 
            'brands' => $brands,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
       

       
        
    }
}
