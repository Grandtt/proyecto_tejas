<?php
namespace App\Controllers;

use App\Models\Usuario;
use App\Middleware\AuthMiddleware;

class AuthController {
    private Usuario $usuarioModel;

    public function __construct() {
        AuthMiddleware::initSession();
        $this->usuarioModel = new Usuario();
    }

    // Muestra y procesa el formulario de Login
    public function login(): void {
        AuthMiddleware::guestOnly();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($email) && !empty($password)) {
                $usuario = $this->usuarioModel->obtenerPorEmail($email);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    // Prevenir fijación de sesión
                    session_regenerate_id(true);

                    $_SESSION['usuario_id']      = $usuario['id'];
                    $_SESSION['usuario_nombre']  = $usuario['nombre'] . ' ' . $usuario['apellido'];
                    $_SESSION['usuario_email']   = $usuario['email'];
                    $_SESSION['usuario_role_id'] = (int)$usuario['role_id'];
                    $_SESSION['usuario_rol']     = $usuario['rol_nombre'];

                    // Redireccionar según el rol
                    if ($_SESSION['usuario_role_id'] === 1) {
                        header('Location: /proyecto_tejas/public/admin/dashboard');
                    } else {
                        header('Location: /proyecto_tejas/public/home/index');
                    }
                    exit;
                } else {
                    $error = "Credenciales incorrectas. Verifica tu correo y contraseña.";
                }
            } else {
                $error = "Por favor completa todos los campos.";
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Muestra y procesa el formulario de Registro
    public function registro(): void {
        AuthMiddleware::guestOnly();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre       = trim($_POST['nombre'] ?? '');
            $apellido     = trim($_POST['apellido'] ?? '');
            $email        = trim($_POST['email'] ?? '');
            $password     = $_POST['password'] ?? '';
            $tipo_cliente = $_POST['tipo_cliente'] ?? 'particular';

            if (!empty($nombre) && !empty($apellido) && !empty($email) && !empty($password)) {
                if ($this->usuarioModel->obtenerPorEmail($email)) {
                    $error = "El correo electrónico ya está registrado.";
                } else {
                    $exito = $this->usuarioModel->registrar([
                        'nombre'       => $nombre,
                        'apellido'     => $apellido,
                        'email'        => $email,
                        'password'     => $password,
                        'tipo_cliente' => $tipo_cliente,
                        'role_id'      => 2 // Cliente
                    ]);

                    if ($exito) {
                        header('Location: /proyecto_tejas/public/auth/login?registro=ok');
                        exit;
                    } else {
                        $error = "Ocurrió un error al registrar el usuario.";
                    }
                }
            } else {
                $error = "Todos los campos obligatorios deben ser diligenciados.";
            }
        }

        require_once __DIR__ . '/../views/auth/registro.php';
    }

    // Cerrar Sesión
    public function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: /proyecto_tejas/public/auth/login');
        exit;
    }


}

