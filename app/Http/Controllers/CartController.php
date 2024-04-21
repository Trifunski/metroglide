<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    
    public function index()
    {
        $cart = new Cart;
        $cart_items = $cart->getCart(1);
        return view('cart', ['cart_items' => $cart_items]);
    }

    public function add(Request $request)
    {
        $cart = new Cart;
        $cart->addToCart(1, $request->product_id, $request->quantity);
        return redirect()->route('cart');
    }

    public function update(Request $request)
    {
        Cart::updateCart(1, $request->product_id, $request->quantity);
        return redirect()->route('cart');
    }

    public function delete(Request $request)
    {
        Cart::deleteFromCart(1, $request->product_id);
        return redirect()->route('cart');
    }

    public function deleteCart()
    {
        Cart::deleteCart(1);
        return redirect()->route('cart');
    }

}
