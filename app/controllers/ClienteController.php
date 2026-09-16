<?php
namespace App\Controllers;

use App\Models\Usuario;

class ClienteController {
    private Usuario $usuarioModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Seguridad: Verificar que el usuario en sesión sea Administrador (rol_id = 1)
        $esAdmin = isset($_SESSION['usuario_role_id']) && (int)$_SESSION['usuario_role_id'] === 1;
        if (!$esAdmin) {
            header('Location: /proyecto_tejas/public/home/index');
            exit;
        }

        $this->usuarioModel = new Usuario();
    }

    // Listar todos los clientes (READ)
    public function index(): void {
        $clientes = $this->usuarioModel->obtenerTodosClientes();
        require_once __DIR__ . '/../views/admin/clientes/index.php';
    }

    // Formulario de edición o proceso de actualización (UPDATE)
    public function editar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $datos = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellido'  => trim($_POST['apellido'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'password'  => $_POST['password'] ?? '',
                'telefono'  => trim($_POST['telefono'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? '')
            ];

            if ($id > 0 && !empty($datos['nombre']) && !empty($datos['email'])) {
                $this->usuarioModel->actualizarCliente($id, $datos);
            }
        }
        header('Location: /proyecto_tejas/public/cliente/index');
        exit;
    }

    // Eliminar un cliente (DELETE)
    public function eliminar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $this->usuarioModel->eliminarCliente($id);
            }
        }
        header('Location: /proyecto_tejas/public/cliente/index');
        exit;
    }
}