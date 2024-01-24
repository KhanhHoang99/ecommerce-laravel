<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function index(){
        // get cart from the session
        $cart = session()->get('cart', []);

        // Calculate the total quantity in the cart
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
        }

        $data = [
            'subject' => 'hello user',
            'body' => 'welcome to user',
            'products' => $cart, 
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ];
        try {
            Mail::to('khanhcontent167@gmail.com')->send(new MailNotify($data));
            return response()->json(['Great check your mail box']);

        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return response()->json(['sorry']);
        }
    }
}
