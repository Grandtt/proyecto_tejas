<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;

class AdminController {

    public function __construct() {
        AuthMiddleware::initSession();
        AuthMiddleware::requireRole(1); // Exclusivo para administradores (rol 1)
    }

    // Método principal del panel de administración
    public function index(): void {
        require_once __DIR__ . '/../views/admin/index.php';
    }

    // Alias dashboard() para redirigir correctamente la ruta admin/dashboard
    public function dashboard(): void {
        $this->index();
    }
}
