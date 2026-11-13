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

            $sqlDetalle = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario) 
                           VALUES (:pedido_id, :producto_id, :cantidad, :precio_unitario)";
            $stmtDetalle = $this->db->prepare($sqlDetalle);

            // CORRECCIÓN: Usar parámetros únicos (:cant_restar y :cant_validar) para evitar el error HY093
            $sqlStock = "UPDATE productos SET stock = stock - :cant_restar WHERE id = :producto_id AND stock >= :cant_validar";
            $stmtStock = $this->db->prepare($sqlStock);

            foreach ($items as $key => $item) {
                $producto_id = $item['id'] ?? $key;
                $cantidad = (int)($item['cantidad'] ?? 1);
                $precio = (float)($item['precio'] ?? 0);

                if ($producto_id <= 0) {
                    throw new Exception("ID de producto inválido en el carrito.");
                }

                // Insertar detalle del pedido
                $stmtDetalle->execute([
                    ':pedido_id'       => $pedido_id,
                    ':producto_id'     => $producto_id,
                    ':cantidad'        => $cantidad,
                    ':precio_unitario' => $precio
                ]);

                // Descontar stock con parámetros únicos
                $stmtStock->execute([
                    ':cant_restar'   => $cantidad,
                    ':producto_id'   => $producto_id,
                    ':cant_validar'  => $cantidad
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

        $stmtItems = $this->db->prepare("
            SELECT dp.*, pr.nombre AS producto_nombre, pr.sku, pr.material 
            FROM detalle_pedidos dp 
            INNER JOIN productos pr ON dp.producto_id = pr.id 
            WHERE dp.pedido_id = :pedido_id
        ");
        $stmtItems->execute([':pedido_id' => $pedido_id]);
        $pedido['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return $pedido;
    }

    public function obtenerTodos(): array {
        $sql = "SELECT p.*, u.nombre, u.apellido 
                FROM pedidos p 
                INNER JOIN usuarios u ON p.usuario_id = u.id 
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado(int $pedido_id, string $nuevo_estado): bool {
        $stmt = $this->db->prepare("UPDATE pedidos SET estado_pedido = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $nuevo_estado, ':id' => $pedido_id]);
    }
}
