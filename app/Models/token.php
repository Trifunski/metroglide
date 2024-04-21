<?php

namespace App\Models;

use App\Models\Database;

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

}