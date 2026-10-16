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
        .main-header { background-color: #2c3e50; color: white; padding: 12px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 100%; }
        
        /* Se amplía el max-width a 1400px y se añade flex-wrap y gap para dar suficiente espacio */
        .nav-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        
        /* white-space: nowrap impide que los textos dentro de los enlaces o botones se rompan en dos líneas */
        .logo a { color: #ecf0f1; font-size: 1.4rem; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 8px; white-space: nowrap; }
        
        .nav-menu { display: flex; list-style: none; gap: 12px; align-items: center; flex-wrap: wrap; }
        .nav-menu li { display: flex; align-items: center; }
        .nav-menu a { color: #ecf0f1; text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: color 0.2s; white-space: nowrap; display: inline-block; }
        .nav-menu a:hover { color: #e67e22; }
        
        .user-badge { background: #34495e; padding: 6px 12px; border-radius: 15px; font-size: 0.85rem; color: #f1c40f; white-space: nowrap; }
        
        .btn-admin-productos { background-color: #f39c12; color: #2c3e50 !important; padding: 6px 12px; border-radius: 4px; font-weight: bold; white-space: nowrap; }
        .btn-admin-productos:hover { background-color: #e67e22; color: white !important; }

        .btn-admin-clientes { background-color: #2980b9; color: white !important; padding: 6px 12px; border-radius: 4px; font-weight: bold; white-space: nowrap; }
        .btn-admin-clientes:hover { background-color: #3498db; }
        
        .btn-admin-proveedores { background-color: #27ae60; color: white !important; padding: 6px 12px; border-radius: 4px; font-weight: bold; white-space: nowrap; }
        .btn-admin-proveedores:hover { background-color: #2ecc71; }

        .btn-logout { background-color: #e74c3c; color: white !important; padding: 6px 12px; border-radius: 4px; font-weight: bold; white-space: nowrap; }
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
                            <a href="/proyecto_tejas/public/admin/dashboard/index" class="btn btn-dark btn-sm text-white me-2 fw-semibold">
                                📊 Métricas y Ventas
                            </a>
                        </li>
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
                        <li>
                            <a href="/proyecto_tejas/public/proveedor/index" class="btn-admin-proveedores">
                                🚚 Gestionar Proveedores
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