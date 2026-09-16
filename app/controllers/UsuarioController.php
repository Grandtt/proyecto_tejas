<?php
namespace App\Controllers;

use App\Models\Usuario;
use App\Middleware\AuthMiddleware;

class UsuarioController {
    private Usuario $usuarioModel;

    public function __construct() {
        AuthMiddleware::initSession();
        AuthMiddleware::requireRole(1); // Exclusivo para Administradores
        $this->usuarioModel = new Usuario();
    }

    // Listar usuarios (READ)
    public function index(): void {
        $usuarios = $this->usuarioModel->obtenerTodos();
        require_once __DIR__ . '/../views/admin/usuarios/index.php';
    }

    // Formulario de creación (CREATE)
    public function crear(): void {
        $roles = $this->usuarioModel->obtenerRoles();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->usuarioModel->crear($_POST)) {
                header('Location: /proyecto_tejas/public/usuario/index?msg=creado');
                exit;
            } else {
                $error = "No se pudo crear el usuario. Verifique si el correo ya existe.";
            }
        }

        require_once __DIR__ . '/../views/admin/usuarios/crear.php';
    }

    // Formulario de edición (UPDATE)
    public function editar(int $id): void {
        $usuario = $this->usuarioModel->obtenerPorId($id);
        $roles = $this->usuarioModel->obtenerRoles();

        if (!$usuario) {
            header('Location: /proyecto_tejas/public/usuario/index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->usuarioModel->actualizar($id, $_POST)) {
                header('Location: /proyecto_tejas/public/usuario/index?msg=actualizado');
                exit;
            }
        }

        require_once __DIR__ . '/../views/admin/usuarios/editar.php';
    }

    // Procesar eliminación (DELETE)
    public function eliminar(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usuarioModel->eliminar($id);
        }
        header('Location: /proyecto_tejas/public/usuario/index?msg=eliminado');
        exit;
    }
}