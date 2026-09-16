<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Categoria {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function obtenerTodas(): array {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function crear(string $nombre, ?string $descripcion, ?string $imagen): bool {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre, descripcion, imagen) VALUES (:nombre, :descripcion, :imagen)");
        return $stmt->execute([
            ':nombre'      => $nombre,
            ':descripcion' => $descripcion,
            ':imagen'      => $imagen
        ]);
    }
}