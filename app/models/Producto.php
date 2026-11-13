<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Producto {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

<<<<<<< HEAD
    // Obtener todos los productos (se mantiene por compatibilidad)
=======
    
>>>>>>> fd5bcdf72fb1a855f9e1e9abc9143d3d656707a7
    public function obtenerTodos(): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    // Obtener solo los productos ACTIVOS (para la administración principal y el catálogo)
    public function obtenerActivos(): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p 
                LEFT JOIN categorias c ON p.categoria_id = c.id 
                WHERE p.estado = 'activo' 
                ORDER BY p.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener productos en BORRADOR o AGOTADOS (para la papelera / gestión de inactivos)
    public function obtenerBorradores(): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p 
                LEFT JOIN categorias c ON p.categoria_id = c.id 
                WHERE p.estado IN ('borrador', 'agotado') 
                ORDER BY p.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener productos con stock crítico (para las alertas del panel de administración)
    public function obtenerStockBajo(int $limite = 5): array {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE stock <= :limite AND estado = 'activo'");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cambiar estado dinámicamente ('activo', 'borrador', 'agotado')
    public function cambiarEstado(int $id, string $estado): bool {
        $stmt = $this->db->prepare("UPDATE productos SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
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
        $sql = "INSERT INTO productos (categoria_id, sku, nombre, descripcion, precio, stock, material, resistencia, dimensiones, peso_kg, rendimiento_m2, imagen, estado) 
                VALUES (:categoria_id, :sku, :nombre, :descripcion, :precio, :stock, :material, :resistencia, :dimensiones, :peso_kg, :rendimiento_m2, :imagen, 'activo')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':categoria_id'   => (int)$datos['categoria_id'],
            ':sku'            => $datos['sku'],
            ':nombre'         => $datos['nombre'],
            ':descripcion'    => $datos['descripcion'] ?? null,
            ':precio'         => (float)$datos['precio'],
            ':stock'          => (int)$datos['stock'],
            ':material'       => $datos['material'],
            ':resistencia'    => $datos['resistencia'] ?? null,
            ':dimensiones'    => $datos['dimensiones'] ?? null,
            ':peso_kg'        => !empty($datos['peso_kg']) ? (float)$datos['peso_kg'] : null,
            ':rendimiento_m2' => !empty($datos['rendimiento_m2']) ? (float)$datos['rendimiento_m2'] : null,
            ':imagen'         => $datos['imagen'] ?? 'default.jpg'
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
            ':categoria_id'   => (int)$datos['categoria_id'],
            ':sku'            => $datos['sku'],
            ':nombre'         => $datos['nombre'],
            ':descripcion'    => $datos['descripcion'] ?? null,
            ':precio'         => (float)$datos['precio'],
            ':stock'          => (int)$datos['stock'],
            ':material'       => $datos['material'],
            ':resistencia'    => $datos['resistencia'] ?? null,
            ':dimensiones'    => $datos['dimensiones'] ?? null,
            ':peso_kg'        => !empty($datos['peso_kg']) ? (float)$datos['peso_kg'] : null,
            ':rendimiento_m2' => !empty($datos['rendimiento_m2']) ? (float)$datos['rendimiento_m2'] : null,
            ':id'             => $id
        ];

        if (!empty($datos['imagen'])) {
            $params[':imagen'] = $datos['imagen'];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar un producto (Delete permanente)
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
                WHERE p.estado = 'activo'";
        
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
<<<<<<< HEAD
=======




>>>>>>> fd5bcdf72fb1a855f9e1e9abc9143d3d656707a7
