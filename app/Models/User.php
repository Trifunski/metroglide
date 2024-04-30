<?php

namespace App\Models;

use App\Models\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        $query = "SELECT * FROM Users";
        return $this->db->fetchAll($query);
    }

    public function show($id)
    {
        $query = "SELECT * FROM Users WHERE User_ID = ?";
        return $this->db->fetch($query, [$id]);
    }

    public function store($data)
    {
        $query = "INSERT INTO Users (User_Name, User_Email, User_Password) VALUES (?, ?, ?)";
        return $this->db->execute($query, [$data['name'], $data['email'], $data['password']]);
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
