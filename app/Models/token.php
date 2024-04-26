<?php

namespace App\Models;

use App\Models\Database;
use Illuminate\Support\Facades\Log;

class Token
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createToken($user_id)
    {
        $token = bin2hex(random_bytes(16));
        $query = "INSERT INTO Tokens (User_ID, Token_Value, Token_Expired_At) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))";
        $this->db->execute($query, [$user_id, $token]);
        return [$token, date('Y-m-d H:i:s', strtotime('+2 hour'))];
    }

    public static function checkToken($token)
    {
        
        $token = session()->get('token');
        $expired_at = session()->get('token_expired_at');

        if ($token == null || $expired_at == null) {
            return false;
        }

        if (strtotime($expired_at) < strtotime(date('Y-m-d H:i:s'))) {
            return false;
        }

        return true;

    }

}