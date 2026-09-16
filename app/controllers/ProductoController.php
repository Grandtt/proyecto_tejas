<?php
namespace App\Controllers;

use App\Models\Producto;
use App\Middleware\AuthMiddleware;

class ProductoController {
    private Producto $productoModel;

    public function __construct() {
        AuthMiddleware::initSession();
        AuthMiddleware::requireRole(1); // Exclusivo para Administradores
        $this->productoModel = new Producto();
    }

    // Listar productos (READ)
    public function index(): void {
        $productos = $this->productoModel->obtenerTodos();
        require_once __DIR__ . '/../views/admin/productos/index.php';
    }

    // Formulario y lógica de creación (CREATE)
    public function crear(): void {
        $categorias = $this->productoModel->obtenerCategorias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST;
            
            // Forzar casting a entero para evitar problemas con la foreign key
            $datos['categoria_id'] = !empty($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
            $datos['imagen'] = $this->subirImagen() ?? 'default.jpg';

            if ($datos['categoria_id'] !== null && $this->productoModel->crear($datos)) {
                header('Location: /proyecto_tejas/public/producto/index?msg=creado');
                exit;
            }
        }

        require_once __DIR__ . '/../views/admin/productos/crear.php';
    }

    // Alias para la ruta /producto/guardar
    public function guardar(): void {
        $this->crear();
    }

    // Formulario y lógica de edición (UPDATE)
    public function editar(int $id): void {
        $producto = $this->productoModel->obtenerPorId($id);
        $categorias = $this->productoModel->obtenerCategorias();

        if (!$producto) {
            header('Location: /proyecto_tejas/public/producto/index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST;
            $datos['categoria_id'] = !empty($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
            
            $nuevaImagen = $this->subirImagen();
            if ($nuevaImagen) {
                $datos['imagen'] = $nuevaImagen;
            }

            if ($this->productoModel->actualizar($id, $datos)) {
                header('Location: /proyecto_tejas/public/producto/index?msg=actualizado');
                exit;
            }
        }

        require_once __DIR__ . '/../views/admin/productos/editar.php';
    }

    // Alias para la ruta /producto/actualizar/$id
    public function actualizar(int $id): void {
        $this->editar($id);
    }

    // Eliminar producto (DELETE)
    public function eliminar(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productoModel->eliminar($id);
        }
        header('Location: /proyecto_tejas/public/producto/index?msg=eliminado');
        exit;
    }

    // Método privado auxiliar para la subida de imágenes
    private function subirImagen(): ?string {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('teja_') . '.' . strtolower($ext);
            $dirDestino = __DIR__ . '/../../public/uploads/';

            if (!is_dir($dirDestino)) {
                mkdir($dirDestino, 0777, true);
            }

            $rutaDestino = $dirDestino . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                return $nombreArchivo;
            }
        }
        return null;
    }
}