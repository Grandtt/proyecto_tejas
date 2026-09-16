<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    private string $host = 'localhost';
    private string $db_name = 'tejas_db';
    private string $username = 'root';
    private string $password = ''; 
    private string $charset = 'utf8mb4';

    // El constructor privado previene instanciación directa (Singleton)
    private function __construct() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $db = new self();
            try {
                $dsn = "mysql:host={$db->host};dbname={$db->db_name};charset={$db->charset}";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$instance = new PDO($dsn, $db->username, $db->password, $options);
            } catch (PDOException $e) {
                die("Error de Conexión a la Base de Datos: " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    // Evitar clonación del objeto
    private function __clone() {}
}