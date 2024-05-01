<?php

namespace App\Models;

use App\Models\Database;
use Illuminate\Support\Facades\Log;

/**
 * Modelo Token para gestionar la autenticación y tokens de sesión en la base de datos.
 */
class Token
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
     * Crea un token de sesión nuevo para un usuario y lo almacena en la base de datos.
     * @param int $user_id ID del usuario para quien se crea el token.
     * @return array Contiene el valor del token y la fecha de expiración.
     */
    public function createToken($user_id)
    {
        $token = bin2hex(random_bytes(16));
        $query = "INSERT INTO Tokens (User_ID, Token_Value, Token_Expired_At) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))";
        $this->db->execute($query, [$user_id, $token]);
        return [$token, date('Y-m-d H:i:s', strtotime('+2 hour'))];
    }

    /**
     * Verifica si el token de sesión proporcionado es válido y no ha expirado.
     * @param string $token El token de sesión a verificar.
     * @return bool Verdadero si el token es válido y no ha expirado, falso en caso contrario.
     */
    public static function checkToken($token)
    {
        if (!isset($_SESSION['token']) || !isset($_SESSION['token_expired_at'])) {
            return false;
        }

        $token = $_SESSION['token'];
        $expired_at = $_SESSION['token_expired_at'];

        if (strtotime($expired_at) < strtotime(date('Y-m-d H:i:s'))) {
            return false;
        }

        return true;
    }
}