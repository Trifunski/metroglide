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

    public function addSize($data)
    {
        $query = "INSERT INTO Sizes (Size_Value) VALUES (?)";
        return $this->db->execute($query, [$data['value']]);
    }

    public function updateSize($data)
    {
        $query = "UPDATE Sizes SET Size_Value = ? WHERE Size_ID = ?";
        return $this->db->execute($query, [$data['value'], $data['id']]);
    }

    public function deleteSize($id)
    {
        $query = "DELETE FROM Sizes WHERE Size_ID = ?";
        return $this->db->execute($query, [$id]);
    }

}
