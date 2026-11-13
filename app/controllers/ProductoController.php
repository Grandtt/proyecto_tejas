<?php
namespace App\Controllers;

use App\Models\Producto;
use App\Middleware\AuthMiddleware;
use PDOException;

class ProductoController {
    private Producto $productoModel;

    public function __construct() {
        AuthMiddleware::initSession();
        AuthMiddleware::requireRole(1); // Exclusivo para Administradores
        $this->productoModel = new Producto();
    }

    // Listar productos activos (READ) con alerta de stock bajo
    public function index(): void {
        $productos = $this->productoModel->obtenerActivos();
        $alertasStock = $this->productoModel->obtenerStockBajo(5); // Productos con 5 o menos unidades
        require_once __DIR__ . '/../views/admin/productos/index.php';
    }

    // Vista de Productos en Borrador o Agotados (Soft Delete)
    public function borradores(): void {
        $borradores = $this->productoModel->obtenerBorradores();
        require_once __DIR__ . '/../views/admin/productos/borradores.php';
    }

    // Enviar producto a borrador (Archivar) mediante ruta limpia
    public function enviarBorrador(int $id): void {
        if ($id > 0) {
            $this->productoModel->cambiarEstado($id, 'borrador');
        }
        header('Location: /proyecto_tejas/public/producto/index?msg=borrador_exito');
        exit;
    }

    // Restaurar producto al catálogo activo mediante ruta limpia
    public function restaurar(int $id): void {
        if ($id > 0) {
            $this->productoModel->cambiarEstado($id, 'activo');
        }
        header('Location: /proyecto_tejas/public/producto/borradores?msg=restaurado_exito');
        exit;
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

    // Alias para la ruta /proyecto_tejas/public/producto/actualizar/$id
    public function actualizar(int $id): void {
        $this->editar($id);
    }

    // 🛡️ Eliminar producto permanentemente (DELETE) adaptado al Snapshot histórico
    public function eliminar(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Al tener configurado el SET NULL y el Snapshot, el borrado es seguro
                $this->productoModel->eliminar($id);
                header('Location: /proyecto_tejas/public/producto/index?msg=eliminado');
                exit;
            } catch (PDOException $e) {
                // Captura general de errores de base de datos por si ocurre cualquier eventualidad
                header('Location: /proyecto_tejas/public/producto/index?msg=error');
                exit;
            }
        }
        header('Location: /proyecto_tejas/public/producto/index');
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