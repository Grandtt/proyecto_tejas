<?php
namespace App\Controllers;

use App\Models\Producto;
use App\Middleware\AuthMiddleware;

class CarritoController {
    private Producto $productoModel;

    public function __construct() {
        AuthMiddleware::initSession();
        $this->productoModel = new Producto();

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // Ver el carrito de compras
    public function index(): void {
        $items = $_SESSION['carrito'];
        $total = 0;

        foreach ($items as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        require_once __DIR__ . '/../views/carrito/index.php';
    }

    // Agregar producto al carrito
    public function agregar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto_id = (int)($_POST['producto_id'] ?? 0);
            $cantidad    = (int)($_POST['cantidad'] ?? 1);

            $producto = $this->productoModel->obtenerPorId($producto_id);

            if ($producto && $cantidad > 0) {
                if (isset($_SESSION['carrito'][$producto_id])) {
                    $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
                } else {
                    $_SESSION['carrito'][$producto_id] = [
                        'id'         => $producto['id'],
                        'nombre'     => $producto['nombre'],
                        'sku'        => $producto['sku'],
                        'precio'     => $producto['precio'],
                        'imagen'     => $producto['imagen'],
                        'material'   => $producto['material'],
                        'cantidad'   => $cantidad
                    ];
                }
            }
        }
        header('Location: /proyecto_tejas/public/carrito/index');
        exit;
    }

    // Quitar un item del carrito
    public function eliminar(int $id): void {
        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
        header('Location: /proyecto_tejas/public/carrito/index');
        exit;
    }

    // Vaciar todo el carrito
    public function vaciar(): void {
        $_SESSION['carrito'] = [];
        header('Location: /proyecto_tejas/public/carrito/index');
        exit;
    }
}