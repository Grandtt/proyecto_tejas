<?php
namespace App\Controllers;

use App\Models\Pedido;

class PedidoController {
    private Pedido $pedidoModel;

    public function __construct() {
        $this->pedidoModel = new Pedido();
    }

    public function misPedidos(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $usuario_id = $_SESSION['usuario_id'] ?? null;
        if (!$usuario_id) {
            header('Location: /proyecto_tejas/public/auth/login');
            exit;
        }

        $esAdmin = isset($_SESSION['usuario_role_id']) && (int)$_SESSION['usuario_role_id'] === 1;

        if ($esAdmin) {
            // PANEL DE ADMINISTRACIÓN: Obtener TODOS los pedidos de la plataforma
            $pedidos = $this->pedidoModel->obtenerTodos();
            require_once __DIR__ . '/../views/admin/pedidos/index.php';
        } else {
            // VISTA CLIENTE: Obtener SOLO los pedidos del usuario en sesión
            $pedidos = $this->pedidoModel->obtenerPorUsuario($usuario_id);
            require_once __DIR__ . '/../views/pedido/mis_pedidos.php';
        }
    }

    // Método opcional para cambiar estado desde el panel Admin
    public function cambiarEstado(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $esAdmin = isset($_SESSION['usuario_role_id']) && (int)$_SESSION['usuario_role_id'] === 1;
        if (!$esAdmin) {
            header('Location: /proyecto_tejas/public/home/index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pedido_id = (int)($_POST['pedido_id'] ?? 0);
            $nuevo_estado = $_POST['estado_pedido'] ?? 'pendiente';

            if ($pedido_id > 0) {
                $this->pedidoModel->cambiarEstado($pedido_id, $nuevo_estado);
            }
        }

        header('Location: /proyecto_tejas/public/pedido/misPedidos');
        exit;
    }
}