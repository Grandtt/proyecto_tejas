<?php
namespace App\Controllers;

class CarritoController {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // Ruta: /carrito o /carrito/index
    public function index() {
        $items = $_SESSION['carrito'];
        $total = 0;

        foreach ($items as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Carga la vista correctamente desde app/views/carrito/index.php
        require_once __DIR__ . '/../views/carrito/index.php';
    }

    // Ruta: /carrito/agregar (por POST)
    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_producto'] ?? null;
            $nombre = $_POST['nombre'] ?? 'Teja sin nombre';
            $precio = (float)($_POST['precio'] ?? 0);
            $cantidad = (int)($_POST['cantidad'] ?? 1);

            if ($id && $cantidad > 0) {
                if (isset($_SESSION['carrito'][$id])) {
                    $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
                } else {
                    $_SESSION['carrito'][$id] = [
                        'nombre' => $nombre,
                        'precio' => $precio,
                        'cantidad' => $cantidad
                    ];
                }
            }
        }

        header('Location: /proyecto_tejas/public/carrito/index');
        exit;
    }

    // Ruta: /carrito/eliminar/{id}
    public function eliminar($id = null) {
        if ($id && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        header('Location: /proyecto_tejas/public/carrito/index');
        exit;
    }

    // Ruta: /carrito/vaciar
    public function vaciar() {
        $_SESSION['carrito'] = [];

        header('Location: /proyecto_tejas/public/carrito/index');
        exit;
    }
}