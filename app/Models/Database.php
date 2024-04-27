<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $port;
    private $charset;

    private $pdo;
    private $stmt;
    private $error;

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

    public function fetchAll($sql, $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this->stmt->fetchAll();
    }

    public function fetch($sql, $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this->stmt->fetch();
    }

    public function execute($sql, $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute($params);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

}