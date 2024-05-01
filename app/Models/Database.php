<?php

namespace App\Models;

use PDO;
use PDOException;

/**
 * Clase Database para gestionar la conexión y operaciones con la base de datos.
 */
class Database
{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $port;
    private $charset;

    /**
     * @var PDO Instancia de PDO para conexiones a la base de datos.
     */
    private $pdo;

    /**
     * @var PDOStatement Statement para operaciones de base de datos.
     */
    private $stmt;

    /**
     * @var string Mensaje de error de la conexión.
     */
    private $error;

    /**
     * Constructor que inicializa la conexión a la base de datos.
     */
    public function __construct()
    {

        $this->host = env('DB_HOST');
        $this->db = env('DB_DATABASE');
        $this->user = env('DB_USERNAME');
        $this->pass = env('DB_PASSWORD');
        $this->port = env('DB_PORT');
        $this->charset = env('DB_CHARSET');

        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";port=" . $this->port . ";charset=" . $this->charset;
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo 'Connection error: ' . $this->error;
        }
    }

    /**
     * Fetch all rows from a query.
     * @param string $sql The SQL query to execute.
     * @param array $params Parameters for the SQL query.
     * @return array An array of rows.
     */
    public function fetchAll($sql, $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this->stmt->fetchAll();
    }

    /**
     * Fetch a single row from a query.
     * @param string $sql The SQL query to execute.
     * @param array $params Parameters for the SQL query.
     * @return array A single row.
     */
    public function fetch($sql, $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this->stmt->fetch();
    }

    /**
     * Execute an SQL statement and return the result.
     * @param string $sql The SQL query to execute.
     * @param array $params Parameters for the SQL query.
     * @return bool True if successful, false otherwise.
     */
    public function execute($sql, $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute($params);
    }

    /**
     * Get the last inserted ID from the database.
     * @return string The last inserted ID.
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

}