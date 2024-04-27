<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Token;

class AuthController extends Controller
{
    private $user;
    private $token;
    private $cart;

    public function __construct()
    {
        $this->user = new User();
        $this->token = new Token();
        $this->cart = new Cart();
    }

    public function login(Request $request)
    {
        session()->flush();

        $request->validate([
            'email' => 'required|email|max:64',
            'password' => 'required|min:8|max:64'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->user->login($email, $password);

        if ($user) {
            $token = $this->token->createToken($user['User_ID']);
            session(['token' => $token[0], 'token_expired_at' => $token[1], 'user_id' => $user['User_ID']]);
            $this->loadUserCartIntoSession($user['User_ID']);
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
    }

    public function loadUserCartIntoSession($userId)
    {
        
        $cart = $this->cart->getCartFromDatabase($userId);

        if ($cart) {
            $formattedCart = [];
            foreach ($cart as $item) {
                $product_key = $item['Sneaker_ID'] . '-' . $item['Size_ID'];
                $formattedCart[$product_key] = [
                    'product_id' => $item['Sneaker_ID'],
                    'size_id' => $item['Size_ID'],
                    'quantity' => $item['Cart_Quantity'],
                    'price_per_unit' => $item['Price_Per_Unit']
                ];
            }
    
            // Guardar el carrito en la sesión
            session(['cart' => $formattedCart]);
        }

    }

    public function logout()
    {

        $this->cart->saveCartToDatabase();
        $this->cart->clearCart();

        session()->flush();

        return redirect()->back()->with('message', 'Logout success');

    }
}
