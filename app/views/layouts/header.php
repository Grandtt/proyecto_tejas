<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validar si el usuario logueado es Administrador según AuthController (usuario_role_id === 1)
$esAdmin = isset($_SESSION['usuario_role_id']) && (int)$_SESSION['usuario_role_id'] === 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Tejas y Materiales</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-header { background-color: #2c3e50; color: white; padding: 12px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo a { color: #ecf0f1; font-size: 1.4rem; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .nav-menu { display: flex; list-style: none; gap: 18px; align-items: center; }
        .nav-menu a { color: #ecf0f1; text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: color 0.2s; }
        .nav-menu a:hover { color: #e67e22; }
        .user-badge { background: #34495e; padding: 5px 12px; border-radius: 15px; font-size: 0.85rem; color: #f1c40f; }
        
        .btn-admin-productos { background-color: #f39c12; color: #2c3e50 !important; padding: 6px 12px; border-radius: 4px; font-weight: bold; }
        .btn-admin-productos:hover { background-color: #e67e22; color: white !important; }

        .btn-admin-clientes { background-color: #2980b9; color: white !important; padding: 6px 12px; border-radius: 4px; font-weight: bold; }
        .btn-admin-clientes:hover { background-color: #3498db; }
        
        .btn-logout { background-color: #e74c3c; color: white !important; padding: 6px 12px; border-radius: 4px; font-weight: bold; }
        .btn-logout:hover { background-color: #c0392b; }
    </style>
</head>
<body>

<header class="main-header">
    <div class="nav-container">
        <div class="logo">
            <!-- Click al logo para redirigir a la vista principal -->
            <a href="/proyecto_tejas/public/home/index">
                <span>🧱</span> <span>Tejas & Cubiertas</span>
            </a>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="/proyecto_tejas/public/catalogo/index">Catálogo</a></li>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="/proyecto_tejas/public/pedido/misPedidos">📦 Mis Pedidos</a></li>

                    <!-- Botones exclusivos para Administrador -->
                    <?php if ($esAdmin): ?>
                        <li>
                            <a href="/proyecto_tejas/public/producto/index" class="btn-admin-productos">
                                🛠️ Gestionar Productos
                            </a>
                        </li>
                        <li>
                            <a href="/proyecto_tejas/public/cliente/index" class="btn-admin-clientes">
                                👥 Gestionar Clientes
                            </a>
                        </li>
                    <?php endif; ?>

                    <li><span class="user-badge">👤 <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?></span></li>
                    <li><a href="/proyecto_tejas/public/auth/logout" class="btn-logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="/proyecto_tejas/public/auth/login">Iniciar Sesión</a></li>
                    <li><a href="/proyecto_tejas/public/auth/registro">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>