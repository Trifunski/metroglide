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

    public function __construct()
    {
        $this->user = new User();
        $this->token = new Token();
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->user->login($email, $password);

        if ($user) {
            $token = $this->token->createToken($user['User_ID']);
            session(['token' => $token[0], 'token_expired_at' => $token[1], 'user_id' => $user['User_ID']]);
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
    }

    public function checkToken()
    {
        $token = session('token');
        $token_expired_at = session('token_expired_at');
        if ($token && $token_expired_at > date('Y-m-d H:i:s')) {
            return response()->json(['message' => 'Token valid']);
        } else {
            return response()->json(['message' => 'Token invalid'], 401);
        }
    }

    public function logout()
    {
        session()->flush();

        return redirect()->back()->with('message', 'Logout success');
    }
}
