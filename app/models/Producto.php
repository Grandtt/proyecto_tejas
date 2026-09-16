<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Producto {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Obtener todos los productos con el nombre de su categoría
    public function obtenerTodos(): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    // Obtener un producto por su ID
    public function obtenerPorId(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $prod = $stmt->fetch();
        return $prod ?: null;
    }

    // Crear un nuevo producto (Create)
    public function crear(array $datos): bool {
        $sql = "INSERT INTO productos (categoria_id, sku, nombre, descripcion, precio, stock, material, resistencia, dimensiones, peso_kg, rendimiento_m2, imagen) 
                VALUES (:categoria_id, :sku, :nombre, :descripcion, :precio, :stock, :material, :resistencia, :dimensiones, :peso_kg, :rendimiento_m2, :imagen)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':categoria_id'  => (int)$datos['categoria_id'],
            ':sku'           => $datos['sku'],
            ':nombre'        => $datos['nombre'],
            ':descripcion'   => $datos['descripcion'] ?? null,
            ':precio'        => (float)$datos['precio'],
            ':stock'         => (int)$datos['stock'],
            ':material'      => $datos['material'],
            ':resistencia'   => $datos['resistencia'] ?? null,
            ':dimensiones'   => $datos['dimensiones'] ?? null,
            ':peso_kg'       => !empty($datos['peso_kg']) ? (float)$datos['peso_kg'] : null,
            ':rendimiento_m2'=> !empty($datos['rendimiento_m2']) ? (float)$datos['rendimiento_m2'] : null,
            ':imagen'        => $datos['imagen'] ?? 'default.jpg'
        ]);
    }

    // Actualizar producto (Update)
    public function actualizar(int $id, array $datos): bool {
        $sql = "UPDATE productos SET 
                categoria_id = :categoria_id, 
                sku = :sku, 
                nombre = :nombre, 
                descripcion = :descripcion, 
                precio = :precio, 
                stock = :stock, 
                material = :material, 
                resistencia = :resistencia, 
                dimensiones = :dimensiones, 
                peso_kg = :peso_kg, 
                rendimiento_m2 = :rendimiento_m2
                " . (!empty($datos['imagen']) ? ", imagen = :imagen" : "") . "
                WHERE id = :id";

        $params = [
            ':categoria_id'  => (int)$datos['categoria_id'],
            ':sku'           => $datos['sku'],
            ':nombre'        => $datos['nombre'],
            ':descripcion'   => $datos['descripcion'] ?? null,
            ':precio'        => (float)$datos['precio'],
            ':stock'         => (int)$datos['stock'],
            ':material'      => $datos['material'],
            ':resistencia'   => $datos['resistencia'] ?? null,
            ':dimensiones'   => $datos['dimensiones'] ?? null,
            ':peso_kg'       => !empty($datos['peso_kg']) ? (float)$datos['peso_kg'] : null,
            ':rendimiento_m2'=> !empty($datos['rendimiento_m2']) ? (float)$datos['rendimiento_m2'] : null,
            ':id'             => $id
        ];

        if (!empty($datos['imagen'])) {
            $params[':imagen'] = $datos['imagen'];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar un producto (Delete)
    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Obtener todas las categorías para los formularios
    public function obtenerCategorias(): array {
        return $this->db->query("SELECT * FROM categorias")->fetchAll();
    }
// Obtener productos aplicando filtros opcionales (Material, Categoría, Precio)
    public function obtenerConFiltros(?string $material = null, ?int $categoria_id = null, ?float $precio_max = null): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                WHERE 1=1";
        
        $params = [];

        if (!empty($material)) {
            $sql .= " AND p.material = :material";
            $params[':material'] = $material;
        }

        if (!empty($categoria_id)) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $categoria_id;
        }

        if (!empty($precio_max)) {
            $sql .= " AND p.precio <= :precio_max";
            $params[':precio_max'] = $precio_max;
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}

// Método a incorporar dentro de la clase App\Models\Producto


