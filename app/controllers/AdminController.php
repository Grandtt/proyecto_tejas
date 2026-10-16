<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Config\Database;
use PDO;

class AdminController {

    public function __construct() {
        AuthMiddleware::initSession();
        AuthMiddleware::requireRole(1); // Exclusivo para administradores (rol 1)
    }

    // Menú Principal de Tarjetas
    public function index(): void {
        require_once __DIR__ . '/../views/admin/index.php';
    }

    // Dashboard con Estadísticas de la Empresa
    public function dashboard(): void {
        // Obtenemos la conexión desde el Singleton de Database
        $db = null;
        if (method_exists(Database::class, 'getInstance')) {
            $instance = Database::getInstance();
            $db = ($instance instanceof PDO) ? $instance : ($instance->getConnection() ?? $instance->db ?? $instance->conn ?? null);
        }
        
        if (!$db || !($db instanceof PDO)) {
            $db = new PDO("mysql:host=localhost;dbname=proyecto_tejas;charset=utf8", "root", "");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        // 1. Contador de Productos
        $totalProductos = 0;
        $tableProd = $db->query("SHOW TABLES LIKE 'productos'")->rowCount() > 0;
        if ($tableProd) {
            $totalProductos = (int) $db->query("SELECT COUNT(*) FROM productos")->fetchColumn();
        }

        // 2. Contador de Usuarios / Clientes
        $totalClientes = 0;
        $tableUsers = $db->query("SHOW TABLES LIKE 'usuarios'")->rowCount() > 0;
        if ($tableUsers) {
            // Intentamos contar con el rol de cliente, si no existe el campo role_id cuenta todos los usuarios
            try {
                $totalClientes = (int) $db->query("SELECT COUNT(*) FROM usuarios WHERE role_id = 2")->fetchColumn();
            } catch (\Exception $e) {
                $totalClientes = (int) $db->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
            }
        }

        // 3. Métricas de Ventas y Pedidos
        $totalVentas = 0;
        $totalPedidos = 0;
        $ultimasVentas = [];

        $tablePedidos = $db->query("SHOW TABLES LIKE 'pedidos'")->rowCount() > 0;
        if ($tablePedidos) {
            // Suma total e importe de pedidos
            try {
                $resVentas = $db->query("SELECT SUM(total) AS total_ventas, COUNT(*) AS total_pedidos FROM pedidos")->fetch(PDO::FETCH_ASSOC);
                $totalVentas = $resVentas['total_ventas'] ?? 0;
                $totalPedidos = $resVentas['total_pedidos'] ?? 0;
            } catch (\Exception $e) {
                $totalPedidos = (int) $db->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
            }

            // Consultar las últimas transacciones de forma adaptable a tus columnas
            try {
                $stmtUltimas = $db->query("
                    SELECT p.id, 
                           COALESCE(u.nombre, 'Cliente') AS cliente, 
                           COALESCE(p.total, 0) AS total, 
                           COALESCE(p.estado, 'Completado') AS estado
                    FROM pedidos p
                    LEFT JOIN usuarios u ON p.usuario_id = u.id
                    ORDER BY p.id DESC
                    LIMIT 5
                ");
                $ultimasVentas = $stmtUltimas->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Exception $e) {
                $ultimasVentas = [];
            }
        }

        // Cargamos la vista del dashboard
        require_once __DIR__ . '/../views/admin/dashboard/index.php';
    }
}