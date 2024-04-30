<?php

namespace App\Models;

use App\Models\Database;

class Size
{
    
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getSizes()
    {
        $query = "SELECT * FROM Sizes";
        return $this->db->fetchAll($query);
    }

    public function getSizeById($id)
    {
        $query = "SELECT * FROM Sizes WHERE Size_ID = ?";
        return $this->db->fetch($query, [$id]);
    }

}
