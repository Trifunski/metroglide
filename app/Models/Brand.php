<?php

namespace App\Models;

use App\Models\Database;

/**
 * Modelo Brand para gestionar la información de marcas en la base de datos.
 */
class Brand
{
    /**
     * @var Database Instancia de la base de datos.
     */
    private $db;

    /**
     * Constructor que inicializa la instancia de la base de datos.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Obtiene todas las marcas disponibles en la base de datos.
     * @return array Lista de marcas.
     */
    public function getBrands()
    {
        $query = "SELECT * FROM Brands";
        return $this->db->fetchAll($query);
    }

    /**
     * Obtiene una marca específica por su ID.
     * @param int $id ID de la marca.
     * @return array Información de la marca.
     */
    public function getBrandById($id)
    {
        $query = "SELECT * FROM Brands WHERE Brand_ID = ?";
        return $this->db->fetch($query, [$id]);
    }

    /**
     * Añade una nueva marca a la base de datos.
     * @param array $data Datos de la marca, incluyendo el nombre.
     * @return bool Resultado de la operación.
     */
    public function addBrand($data)
    {
        $query = "INSERT INTO Brands (Brand_Name) VALUES (?)";
        return $this->db->execute($query, [$data['name']]);
    }
}
