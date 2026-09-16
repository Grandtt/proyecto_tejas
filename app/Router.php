<?php
namespace App;

class Router {
    public function run(): void {
        // Obtener la URL solicitada o redirigir por defecto a home/index
        $url = $_GET['url'] ?? 'home/index';
        $url = filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL);
        $segments = explode('/', $url);

        // 1. Mapear Nombre del Controlador (ej: 'cliente' -> 'ClienteController')
        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
        $controllerClass = "App\\Controllers\\" . $controllerName;

        // 2. Mapear Nombre del Método (ej: 'index', 'crear', 'editar', 'eliminar')
        $method = $segments[1] ?? 'index';

        // 3. Capturar Parámetros adicionales
        $params = array_slice($segments, 2);

        // 4. Despachar la petición si la clase y el método existen
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                $this->notFound("El método '{$method}' no existe en el controlador '{$controllerName}'");
            }
        } else {
            $this->notFound("El controlador '{$controllerName}' no fue encontrado");
        }
    }

    private function notFound(string $message): void {
        http_response_code(404);
        echo "<h1>404 - Página No Encontrada</h1><p>{$message}</p>";
    }
}