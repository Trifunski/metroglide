<?php

namespace App\Models;

use App\Models\Database;

/**
 * Modelo User para gestionar las operaciones de autenticación de usuarios.
 */
class User
{
    /**
     * @var Database Instancia de la base de datos.
     */
    private $db;

    /**
     * Constructor que inicializa la instancia de la base de datos y comienza la sesión.
     */
    public function __construct()
    {
        $this->db = new Database();
        session_start();
    }

    /**
     * Autentica a un usuario basándose en su email y contraseña.
     * @param string $email El email del usuario.
     * @param string $password La contraseña del usuario.
     * @return array|null Retorna los datos del usuario si la autenticación es exitosa, null en caso contrario.
     */
    public function login($email, $password)
    {
        $query = "SELECT * FROM Users WHERE User_Email = ? AND User_Password = ?";
        return $this->db->fetch($query, [$email, $password]);
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        session_destroy();
    }
}
