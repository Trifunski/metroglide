<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Token;

class CartController extends Controller
{
    public function __construct()
    {
        session_start(); 
    }

    public function getCart(Request $request)
    {
        $token = $_SESSION['token'] ?? null;

        if (Token::checkToken($token) === false) {
            return response()->json([
                'message' => 'Please log in to view cart'
            ]);
        }

        $cart = Cart::getCart();
        
        return response()->json($cart);
    }

    public function addCart(Request $request)
    {
        $request->validate([
            'sneakerId' => 'required',
            'quantity' => 'required',
            'sizeId' => 'required',
            'price' => 'required'
        ]);

        $token = $_SESSION['token'] ?? null;

        if (Token::checkToken($token) === false) {
            return response()->json([
                'message' => 'Please log in to add to cart'
            ]);
        }

        $sneaker_id = $request->input('sneakerId');
        $user_id = $_SESSION['user_id'] ?? null;
        $quantity = $request->input('quantity');
        $size_id = $request->input('sizeId');
        $price = $request->input('price');

        $sizeModel = new Size();
        $size = $sizeModel->getSizeById($size_id);

        if (empty($size)) {
            return response()->json([
                'message' => 'Size not valid'
            ]);
        }
        
        Cart::addCart($sneaker_id, $user_id, $size_id, $quantity, $price);
        
        return response()->json([
            'message' => 'Product added to cart'
        ]);
    }

    public function updateCart(Request $request)
    {
        $token = $_SESSION['token'] ?? null;

        if (Token::checkToken($token) === false) {
            return response()->json([
                'message' => 'Please log in to update cart'
            ]);
        }

        $sneaker_id = $request->input('sneaker_id');
        $quantity = $request->input('quantity');
        
        Cart::updateCart($sneaker_id, $quantity);
        
        return response()->json([
            'message' => 'Cart updated'
        ]);
    }
    
    public function removeCart(Request $request)
    {
        $token = $_SESSION['token'] ?? null;

        if (Token::checkToken($token) === false) {
            return response()->json([
                'message' => 'Please log in to remove from cart'
            ]);
        }

        $request->validate([
            'sneakerId' => 'required',
            'sizeId' => 'required',
            'quantity' => 'required'
        ]);

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
        $token = $_SESSION['token'] ?? null;

        if (Token::checkToken($token) === false) {
            return response()->json([
                'message' => 'Please log in to clear cart'
            ]);
        }

        Cart::clearCart();
        
        return response()->json([
            'message' => 'Cart cleared'
        ]);
    }

    public function checkout(Request $request)
    {
        $token = $_SESSION['token'] ?? null;

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
        $token = $_SESSION['token'] ?? null;

        if (Token::checkToken($token) === false) {
            return response()->json([
                'message' => 'Please log in to complete checkout'
            ]);
        }

        $user = $_SESSION['user_id'] ?? null;

        Cart::saveCheckoutToDatabase($user);
        Cart::clearCart();
        
        return response()->json([
            'message' => 'Checkout completed'
        ]);
    }
}