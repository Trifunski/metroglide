<?php

namespace App\Models;

use App\Models\Database;
use Illuminate\Support\Facades\Log;

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

    public function filter($data)
    {
        // Variables para controlar las condiciones de la consulta
        $brandConditions = '';
        $sizeConditions = '';
        $params = [];

        // Verificar y preparar condiciones para marcas
        if (!empty($data['brands'])) {
            $brandPlaceholders = implode(',', array_fill(0, count($data['brands']), '?'));
            $brandConditions = "Sneakers.Brand_ID IN ($brandPlaceholders)";
            $params = array_merge($params, $data['brands']);
        }

        // Verificar y preparar condiciones para tamaños
        if (!empty($data['sizes'])) {
            $sizePlaceholders = implode(',', array_fill(0, count($data['sizes']), '?'));
            $sizeConditions = "Sneaker_Sizes.Size_ID IN ($sizePlaceholders)";
            $params = array_merge($params, $data['sizes']);
        }

        // Construir la consulta SQL base
        $query = "SELECT DISTINCT Sneakers.* FROM Sneakers";
        $conditions = [];

        // Incluir la unión con Sneaker_Sizes si hay condiciones de tamaño
        if (!empty($sizeConditions)) {
            $query .= " JOIN Sneaker_Sizes ON Sneakers.Sneaker_ID = Sneaker_Sizes.Sneaker_ID";
            $conditions[] = $sizeConditions;
        }

        // Añadir condiciones de marcas si existen
        if (!empty($brandConditions)) {
            $conditions[] = $brandConditions;
        }

        // Combinar todas las condiciones en la cláusula WHERE si hay alguna
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        // Ejecutar la consulta y devolver los resultados
        return $this->db->fetchAll($query, $params);
    }

    

}
