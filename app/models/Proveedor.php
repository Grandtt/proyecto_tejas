<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Proveedor {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function obtenerTodos(): array {
        $sql = "SELECT * FROM proveedores ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
        return $proveedor ?: null;
    }

    public function crear(array $datos): bool {
        $sql = "INSERT INTO proveedores (nit, nombre, contacto, telefono, email, direccion, estado) 
                VALUES (:nit, :nombre, :contacto, :telefono, :email, :direccion, 'activo')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nit'       => $datos['nit'],
            ':nombre'    => $datos['nombre'],
            ':contacto'  => $datos['contacto'] ?? null,
            ':telefono'  => $datos['telefono'] ?? null,
            ':email'     => $datos['email'] ?? null,
            ':direccion' => $datos['direccion'] ?? null
        ]);
    }

    public function actualizar(int $id, array $datos): bool {
        $sql = "UPDATE proveedores 
                SET nit = :nit, nombre = :nombre, contacto = :contacto, 
                    telefono = :telefono, email = :email, direccion = :direccion, estado = :estado 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'        => $id,
            ':nit'       => $datos['nit'],
            ':nombre'    => $datos['nombre'],
            ':contacto'  => $datos['contacto'] ?? null,
            ':telefono'  => $datos['telefono'] ?? null,
            ':email'     => $datos['email'] ?? null,
            ':direccion' => $datos['direccion'] ?? null,
            ':estado'    => $datos['estado'] ?? 'activo'
        ]);
    }

    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM proveedores WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
