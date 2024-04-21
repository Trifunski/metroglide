<?php

namespace App\Models;

use App\Models\Database;

class Sneaker 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        $query = "SELECT * FROM Sneakers";
        return $this->db->fetchAll($query);
    }

    public function show($id)
    {
        $query = "SELECT * FROM Sneakers WHERE Sneaker_ID = ?";
        return $this->db->fetch($query, [$id]);
    }

    public function store($data)
    {
        $query = "INSERT INTO Sneakers (Brand_ID, Sneaker_Model, Sneaker_Description, Sneaker_Price, Sneaker_Stock, Sneaker_ImageURL) VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->execute($query, [$data['brand_id'], $data['model'], $data['description'], $data['price'], $data['stock'], $data['image_url']]);
    }

    public function update($id, $data)
    {
        $query = "UPDATE Sneakers SET Sneaker_Model = ?, Sneaker_Description = ?, Sneaker_Price = ?, Sneaker_Stock = ?, Sneaker_ImageURL = ? WHERE Sneaker_ID = ?";
        return $this->db->execute($query, [$data['model'], $data['description'], $data['price'], $data['stock'], $data['image_url'], $id]);
    }

    public function destroy($id)
    {
        $query = "DELETE FROM Sneakers WHERE Sneaker_ID = ?";
        return $this->db->execute($query, [$id]);
    }

    public function indexByBrand($brand_id)
    {
        $query = "SELECT * FROM Sneakers WHERE Brand_ID = ?";
        return $this->db->fetchAll($query, [$brand_id]);
    }

    public function indexBySize($size_id)
    {
        $query = "SELECT s.* FROM Sizes s JOIN Sneaker_Sizes ss ON s.Size_ID = ss.Size_ID WHERE ss.Sneaker_ID = ?";
        return $this->db->fetchAll($query, [$size_id]);
    }

}
