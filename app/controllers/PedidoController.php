<?php
namespace App\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Exception;

class PedidoController {
    private Pedido $pedidoModel;
    private Producto $productoModel;

    public function __construct() {
        $this->pedidoModel = new Pedido();
        $this->productoModel = new Producto();
    }

    // Método por defecto para que /pedido o /pedido/index funcione correctamente
    public function index(): void {
        $this->misPedidos();
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

    public function checkout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $usuario_id = $_SESSION['usuario_id'] ?? null;
        if (!$usuario_id) {
            header('Location: /proyecto_tejas/public/auth/login');
            exit;
        }

        // Si el usuario envía el formulario de compra (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $carrito = $_SESSION['carrito'] ?? [];
            
            if (empty($carrito)) {
                header('Location: /proyecto_tejas/public/catalogo/index');
                exit;
            }

            // Recoger los datos del formulario aceptando múltiples nombres posibles para los inputs
            $direccion = $_POST['direccion_entrega'] ?? $_POST['direccion_envio'] ?? $_POST['direccion'] ?? 'Sin dirección';
            $metodo_pago = $_POST['metodo_pago'] ?? 'Contra entrega';

            // 📸 Construir el carrito enriquecido con el Snapshot (fotografía histórica del producto)
            $total = 0;
            $carritoEnriquecido = [];

            foreach ($carrito as $key => $item) {
                // Identificar el ID del producto de forma robusta (clave del array, producto_id o id)
                $producto_id = (int)($item['producto_id'] ?? $item['id'] ?? $key ?? 0);
                $cantidad = (int)($item['cantidad'] ?? 1);

                // Obtener los datos actuales del producto desde la base de datos (si el ID es válido)
                $productoActual = $producto_id > 0 ? $this->productoModel->obtenerPorId($producto_id) : null;

                // Respaldar datos actuales o usar los que ya traía el carrito como respaldo
                $nombre = $productoActual['nombre'] ?? $item['nombre'] ?? $item['nombre_producto'] ?? 'Producto';
                $sku = $productoActual['sku'] ?? $item['sku'] ?? $item['sku_producto'] ?? 'N/A';
                $precioUnitario = (float)($productoActual['precio'] ?? $item['precio'] ?? $item['precio_unitario'] ?? 0);

                if ($producto_id > 0 || $precioUnitario > 0) {
                    $total += $precioUnitario * $cantidad;

                    // Guardamos tanto los datos relacionales como el respaldo histórico (Snapshot)
                    $carritoEnriquecido[] = [
                        'producto_id'     => $producto_id > 0 ? $producto_id : 1,
                        'cantidad'        => $cantidad,
                        'precio'          => $precioUnitario,
                        'nombre_producto' => $nombre,
                        'sku_producto'    => $sku,
                        'precio_unitario' => $precioUnitario
                    ];
                }
            }

            if (empty($carritoEnriquecido)) {
                header('Location: /proyecto_tejas/public/carrito/index?msg=error_carrito');
                exit;
            }

            try {
<<<<<<< HEAD
                // Intentar registrar el pedido con el carrito enriquecido y descontar stock
                $pedido_id = $this->pedidoModel->registrarPedido($usuario_id, $carritoEnriquecido, $total, $direccion, $metodo_pago);
=======
<<<<<<< HEAD
                //registrar el pedido y descontar stock
=======
                // Intentar registrar el pedido y descontar stock
>>>>>>> c98ba225824aea18ac062548418d245d2fdfdc7b
                $pedido_id = $this->pedidoModel->registrarPedido($usuario_id, $carrito, $total, $direccion, $metodo_pago);
>>>>>>> fd5bcdf72fb1a855f9e1e9abc9143d3d656707a7

                if ($pedido_id) {
                    // Vaciar el carrito de la sesión si se guardó con éxito
                    unset($_SESSION['carrito']);

                    // Redirigir al historial de pedidos
                    header('Location: /proyecto_tejas/public/pedido/misPedidos');
                    exit;
                } else {
                    throw new Exception("El modelo no devolvió un ID de pedido válido.");
                }

            } catch (Exception $ex) {
                echo "<div style='max-width: 700px; margin: 40px auto; padding: 20px; background: #ffe6e6; border: 1px solid #e74c3c; border-radius: 6px; font-family: Arial, sans-serif;'>";
                echo "<h3 style='color: #c0392b; margin-top: 0;'>❌ Error detallado al procesar el pedido:</h3>";
                echo "<p style='color: #333; font-size: 1.1rem;'>" . htmlspecialchars($ex->getMessage()) . "</p>";
                echo "<hr style='border:0; border-top:1px solid #ccc; margin: 15px 0;'>";
                echo "<a href='/proyecto_tejas/public/carrito/index' style='background: #34495e; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block;'>← Volver al Carrito</a>";
                echo "</div>";
                exit;
            }
        }

<<<<<<< HEAD
        //la vista de pago/checkout
=======
        // Si entra por GET, muestra la vista de pago/checkout
>>>>>>> c98ba225824aea18ac062548418d245d2fdfdc7b
        require_once __DIR__ . '/../views/carrito/checkout.php';
    }

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