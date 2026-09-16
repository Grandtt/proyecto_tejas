<?php
namespace App\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Middleware\AuthMiddleware;

class CatalogoController {
    private Producto $productoModel;
    private Categoria $categoriaModel;

    public function __construct() {
        AuthMiddleware::initSession();
        $this->productoModel = new Producto();
        $this->categoriaModel = new Categoria();
    }

    // Tienda pública con filtros
    public function index(): void {
        $material     = $_GET['material'] ?? null;
        $categoria_id = isset($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : null;
        $precio_max   = isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : null;

        $productos  = $this->productoModel->obtenerConFiltros($material, $categoria_id, $precio_max);
        $categorias = $this->categoriaModel->obtenerTodas();

        require_once __DIR__ . '/../views/catalogo/index.php';
    }

    // Ficha técnica individual
    public function detalle(int $id): void {
        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            http_response_code(404);
            echo "<h1>Teja o producto no encontrado</h1>";
            exit;
        }

        require_once __DIR__ . '/../views/catalogo/detalle.php';
    }
}