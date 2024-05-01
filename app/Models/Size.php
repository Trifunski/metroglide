<?php

namespace App\Models;

use App\Models\Database;

/**
 * Modelo Size para gestionar la información de tallas en la base de datos.
 */
class Size
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
     * Obtiene todas las tallas disponibles en la base de datos.
     * @return array Lista de tallas.
     */
    public function getSizes()
    {
        $query = "SELECT * FROM Sizes";
        return $this->db->fetchAll($query);
    }

    /**
     * Obtiene una talla específica por su ID.
     * @param int $id ID de la talla.
     * @return array Información de la talla.
     */
    public function getSizeById($id)
    {
        $query = "SELECT * FROM Sizes WHERE Size_ID = ?";
        return $this->db->fetch($query, [$id]);
    }

}
