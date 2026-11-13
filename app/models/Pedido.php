<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use Exception;

class Pedido {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function registrarPedido(int $usuario_id, array $items, float $total, string $direccion, string $metodo_pago): int|bool {
        try {
            $this->db->beginTransaction();

            $sqlPedido = "INSERT INTO pedidos (usuario_id, total, direccion_envio, metodo_pago, estado_pedido) 
                          VALUES (:usuario_id, :total, :direccion, :metodo_pago, 'pendiente')";
            
            $stmt = $this->db->prepare($sqlPedido);
            $stmt->execute([
                ':usuario_id'  => $usuario_id,
                ':total'       => $total,
                ':direccion'   => $direccion,
                ':metodo_pago' => $metodo_pago
            ]);

            $pedido_id = (int)$this->db->lastInsertId();

            if ($pedido_id <= 0) {
                throw new Exception("No se pudo generar el ID del pedido.");
            }

            // 📸 Consulta de inserción adaptada para guardar el Snapshot histórico
            $sqlDetalle = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, nombre_producto, sku_producto, precio_unitario) 
                           VALUES (:pedido_id, :producto_id, :cantidad, :nombre_producto, :sku_producto, :precio_unitario)";
            $stmtDetalle = $this->db->prepare($sqlDetalle);

<<<<<<< HEAD
            $sqlStock = "UPDATE productos 
                         SET stock = stock - :cant_restar,
                             estado = CASE WHEN (stock - :cant_validar_estado) <= 0 THEN 'agotado' ELSE estado END
                         WHERE id = :producto_id AND stock >= :cant_validar_stock";
=======
<<<<<<< HEAD
            
=======
            // CORRECCIÓN: Usar parámetros únicos (:cant_restar y :cant_validar) para evitar el error HY093
>>>>>>> c98ba225824aea18ac062548418d245d2fdfdc7b
            $sqlStock = "UPDATE productos SET stock = stock - :cant_restar WHERE id = :producto_id AND stock >= :cant_validar";
>>>>>>> fd5bcdf72fb1a855f9e1e9abc9143d3d656707a7
            $stmtStock = $this->db->prepare($sqlStock);

            foreach ($items as $item) {
                $producto_id = (int)($item['producto_id'] ?? 0);
                $cantidad = (int)($item['cantidad'] ?? 1);
                
                // Recoger los datos del snapshot enviados desde el controlador
                $nombre_producto = $item['nombre_producto'] ?? 'Producto';
                $sku_producto    = $item['sku_producto'] ?? 'N/A';
                $precio_unitario = (float)($item['precio_unitario'] ?? $item['precio'] ?? 0);

                if ($producto_id <= 0) {
                    throw new Exception("ID de producto inválido en el carrito.");
                }

                // Insertar detalle con la fotografía histórica
                $stmtDetalle->execute([
                    ':pedido_id'       => $pedido_id,
                    ':producto_id'     => $producto_id,
                    ':cantidad'        => $cantidad,
                    ':nombre_producto' => $nombre_producto,
                    ':sku_producto'    => $sku_producto,
                    ':precio_unitario' => $precio_unitario
                ]);

                // Descontar stock y actualizar estado con parámetros únicos
                $stmtStock->execute([
                    ':cant_restar'         => $cantidad,
                    ':cant_validar_estado' => $cantidad,
                    ':producto_id'         => $producto_id,
                    ':cant_validar_stock'  => $cantidad
                ]);

                if ($stmtStock->rowCount() === 0) {
                    throw new Exception("Stock insuficiente para el producto ID: " . $producto_id);
                }
            }

            $this->db->commit();
            return $pedido_id;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error en Checkout: " . $e->getMessage());
            throw $e;
        }
    }

    public function obtenerPorUsuario(int $usuario_id): array {
        $sql = "SELECT id, total, direccion_envio, metodo_pago, estado_pedido, created_at 
                FROM pedidos 
                WHERE usuario_id = :usuario_id 
                ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDetalle(int $pedido_id): ?array {
        $stmt = $this->db->prepare("
            SELECT p.*, u.nombre, u.apellido, u.email, u.telefono 
            FROM pedidos p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            WHERE p.id = :id
        ");
        $stmt->execute([':id' => $pedido_id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedido) return null;

        // 🛡️ Consulta protegida con LEFT JOIN y COALESCE para preservar el historial ante borrados
        $stmtItems = $this->db->prepare("
            SELECT 
                dp.*, 
                COALESCE(dp.nombre_producto, pr.nombre, 'Producto Eliminado') AS producto_nombre, 
                COALESCE(dp.sku_producto, pr.sku, 'N/A') AS sku, 
                pr.material 
            FROM detalle_pedidos dp 
            LEFT JOIN productos pr ON dp.producto_id = pr.id 
            WHERE dp.pedido_id = :pedido_id
        ");
        $stmtItems->execute([':pedido_id' => $pedido_id]);
        $pedido['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return $pedido;
    }

    public function obtenerTodos(): array {
        // 📦 Consulta optimizada con GROUP_CONCAT para agrupar los productos y cantidades de cada pedido
        $sql = "SELECT p.*, u.nombre, u.apellido,
                GROUP_CONCAT(CONCAT(dp.cantidad, 'x ', COALESCE(dp.nombre_producto, pr.nombre, 'Producto Eliminado')) SEPARATOR '<br>') AS productos_resumen
                FROM pedidos p 
                INNER JOIN usuarios u ON p.usuario_id = u.id 
                LEFT JOIN detalle_pedidos dp ON p.id = dp.pedido_id
                LEFT JOIN productos pr ON dp.producto_id = pr.id
                GROUP BY p.id
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado(int $pedido_id, string $nuevo_estado): bool {
        $stmt = $this->db->prepare("UPDATE pedidos SET estado_pedido = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $nuevo_estado, ':id' => $pedido_id]);
    }
}