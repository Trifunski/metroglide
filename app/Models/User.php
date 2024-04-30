<?php

namespace App\Models;

use App\Models\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        session_start();
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM Users WHERE User_Email = ? AND User_Password = ?";
        return $this->db->fetch($query, [$email, $password]);
    }

    public function logout()
    {
        session_destroy();
    }
}
