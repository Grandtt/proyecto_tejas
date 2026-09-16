<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Usuario {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Buscar usuario por correo (Login)
    public function obtenerPorEmail(string $email): ?array {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?: null;
    }

    // Registrar nuevo usuario (Público)
    public function registrar(array $datos): bool {
        return $this->crearCliente($datos);
    }

    // Obtener todos los clientes (Panel Admin - Sin created_at)
    public function obtenerTodosClientes(): array {
        $sql = "SELECT id, nombre, apellido, email, telefono, direccion 
                FROM usuarios 
                WHERE rol_id != 1 OR rol_id IS NULL
                ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener cliente por ID
    public function obtenerPorId(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, nombre, apellido, email, telefono, direccion FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?: null;
    }

    // Crear cliente (Admin / Registro)
    public function crearCliente(array $datos): bool {
        $sql = "INSERT INTO usuarios (nombre, apellido, email, password, telefono, direccion, rol_id) 
                VALUES (:nombre, :apellido, :email, :password, :telefono, :direccion, 2)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'    => $datos['nombre'],
            ':apellido'  => $datos['apellido'],
            ':email'     => $datos['email'],
            ':password'  => password_hash($datos['password'], PASSWORD_BCRYPT),
            ':telefono'  => $datos['telefono'] ?? null,
            ':direccion' => $datos['direccion'] ?? null
        ]);
    }

    // Actualizar cliente
    public function actualizarCliente(int $id, array $datos): bool {
        if (!empty($datos['password'])) {
            $sql = "UPDATE usuarios 
                    SET nombre = :nombre, apellido = :apellido, email = :email, 
                        telefono = :telefono, direccion = :direccion, password = :password 
                    WHERE id = :id";
            $params = [
                ':id'        => $id,
                ':nombre'    => $datos['nombre'],
                ':apellido'  => $datos['apellido'],
                ':email'     => $datos['email'],
                ':telefono'  => $datos['telefono'] ?? null,
                ':direccion' => $datos['direccion'] ?? null,
                ':password'  => password_hash($datos['password'], PASSWORD_BCRYPT)
            ];
        } else {
            $sql = "UPDATE usuarios 
                    SET nombre = :nombre, apellido = :apellido, email = :email, 
                        telefono = :telefono, direccion = :direccion 
                    WHERE id = :id";
            $params = [
                ':id'        => $id,
                ':nombre'    => $datos['nombre'],
                ':apellido'  => $datos['apellido'],
                ':email'     => $datos['email'],
                ':telefono'  => $datos['telefono'] ?? null,
                ':direccion' => $datos['direccion'] ?? null
            ];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar cliente
    public function eliminarCliente(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = :id AND (rol_id != 1 OR rol_id IS NULL)");
        return $stmt->execute([':id' => $id]);
    }
}