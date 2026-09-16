<?php
namespace App\Middleware;

class AuthMiddleware {
    
    public static function initSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Verifica que el usuario haya iniciado sesión
    public static function requireLogin(): void {
        self::initSession();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /proyecto_tejas/public/auth/login');
            exit;
        }
    }

    // Verifica que el usuario tenga un rol específico (ej: 1 = Admin)
    public static function requireRole(int $roleId): void {
        self::requireLogin();
        if ($_SESSION['usuario_role_id'] !== $roleId) {
            http_response_code(403);
            echo "<h1>403 - Acceso Denegado</h1><p>No tienes permisos para acceder a este módulo.</p>";
            exit;
        }
    }

    // Evita que usuarios ya logueados vuelvan a ver el formulario de Login/Registro
    public static function guestOnly(): void {
        self::initSession();
        if (isset($_SESSION['usuario_id'])) {
            header('Location: /proyecto_tejas/public/home/index');
            exit;
        }
    }
}