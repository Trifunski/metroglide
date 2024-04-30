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

    private function validateLogin(Request $request)
    {
        $errors = [];
        $email = $request->input('email');
        $password = $request->input('password');

        if (empty($email)) {
            $errors['email'][] = 'The email field is required.';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'][] = 'The email must be a valid email address.';
            }
            if (strlen($email) > 64) {
                $errors['email'][] = 'The email must not be more than 64 characters.';
            }
        }

        if (empty($password)) {
            $errors['password'][] = 'The password field is required.';
        } else {
            if (strlen($password) < 8) {
                $errors['password'][] = 'The password must be at least 8 characters long.';
            }
            if (strlen($password) > 64) {
                $errors['password'][] = 'The password must not be more than 64 characters.';
            }
        }

        return $errors;
    }

    public function login(Request $request)
    {
        session_destroy();
        session_start();

        $errors = $this->validateLogin($request);
        if (!empty($errors)) {
            return response()->json($errors, 422);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->user->login($email, $password);

        if ($user) {
            $token = $this->token->createToken($user['User_ID']);
            $_SESSION['token'] = $token[0];
            $_SESSION['token_expired_at'] = $token[1];
            $_SESSION['user_id'] = $user['User_ID'];
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

            $_SESSION['cart'] = $formattedCart;
        }
    }

    public function logout()
    {
        $this->cart->saveCartToDatabase();
        $this->cart->clearCart();
        session_destroy();
        return redirect()->back()->with('message', 'Logout success');
    }
}