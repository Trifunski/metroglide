<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Log;
use App\Models\Token;

class CartController extends Controller
{
    
    public function getCart(Request $request)
    {
        $cart = Cart::getCart();
        
        return response()->json($cart);
    }

    public function addCart(Request $request)
    {
        $sneaker_id = $request->input('sneakerId');
        $user_id = session()->get('user_id');
        $quantity = $request->input('quantity');
        $size_id = $request->input('sizeId');
        $price = $request->input('price');
        
        Cart::addCart($sneaker_id, $user_id, $size_id, $quantity, $price);
        
        return response()->json([
            'message' => 'Product added to cart'
        ]);
    }

    public function updateCart(Request $request)
    {
        $sneaker_id = $request->input('sneaker_id');
        $quantity = $request->input('quantity');
        
        Cart::updateCart($sneaker_id, $quantity);
        
        return response()->json([
            'message' => 'Cart updated'
        ]);
    }
    
    public function removeCart(Request $request)
    {

        $sneaker_id = $request->input('sneakerId');
        $size_id = $request->input('sizeId');
        $quantity = $request->input('quantity');
        
        Cart::removeCart($sneaker_id, $size_id, $quantity);

        return response()->json([
            'message' => 'Product removed from cart'
        ]);
    }

    public function clearCart(Request $request)
    {
        Cart::clearCart();
        
        return response()->json([
            'message' => 'Cart cleared'
        ]);
    }

    public function checkout(Request $request)
    {

        $token = session()->get('token');

        if (Token::checkToken($token) === false) {
            return response()->json([
                'message' => 'Token is invalid'
            ], 401);
        }

        $cart = Cart::checkout();
        
        return response()->json($cart);
    }

    public function completed()
    {

        $user = session()->get('user_id');

        Cart::saveCheckoutToDatabase($user);
        Cart::clearCart();

        Log::info('Checkout completed');
        
        return response()->json([
            'message' => 'Checkout completed'
        ]);
    }

}
