<?php
namespace App\Controllers;

use App\Models\Proveedor;

class ProveedorController {
    private Proveedor $model;

    public function __construct() {
        $this->model = new Proveedor();
    }

    
    public function index(?string $idEditar = null): void {
        $proveedores = $this->model->obtenerTodos();
        $proveedor_editar = null;

        if ($idEditar !== null) {
            $proveedor_editar = $this->model->obtenerPorId((int)$idEditar);
        }

        require_once __DIR__ . '/../views/admin/proveedores/index.php';
    }

    
    public function guardar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $datos = [
                'nit'       => trim($_POST['nit']),
                'nombre'    => trim($_POST['nombre']),
                'contacto'  => trim($_POST['contacto']),
                'telefono'  => trim($_POST['telefono']),
                'email'     => trim($_POST['email']),
                'direccion' => trim($_POST['direccion']),
                'estado'    => $_POST['estado'] ?? 'activo'
            ];

            if ($id) {
                $this->model->actualizar((int)$id, $datos);
            } else {
                $this->model->crear($datos);
            }

            header("Location: index.php?url=proveedor/index");
            exit;
        }
    }

    
    public function eliminar(string $id): void {
        if ($id) {
            $this->model->eliminar((int)$id);
        }
        header("Location: index.php?url=proveedor/index");
        exit;
    }
}