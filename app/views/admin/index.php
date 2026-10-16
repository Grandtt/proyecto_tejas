<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    .admin-dashboard {
        max-width: 1100px;
        margin: 20px auto;
        padding: 20px;
    }
    .welcome-card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .welcome-card h2 {
        color: #2c3e50;
        margin-bottom: 5px;
    }
    .welcome-card p {
        color: #555;
        margin: 0;
    }
    .grid-admin-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }
    .admin-card {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.12);
    }
    .admin-card-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    .admin-card h3 {
        color: #2c3e50;
        margin-bottom: 10px;
    }
    .admin-card p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    .btn-card {
        display: inline-block;
        padding: 10px 20px;
        background-color: #e67e22;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }
    .btn-card:hover {
        opacity: 0.9;
    }
</style>

<div class="admin-dashboard">
    <div class="welcome-card">
        <div>
            <h2>Panel Administrativo de Control</h2>
            <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador') ?></strong></p>
        </div>
        <div>
            <a href="/proyecto_tejas/public/auth/logout" style="color: #e74c3c; font-weight: bold; text-decoration: none;">Cerrar Sesión</a>
        </div>
    </div>

    <div class="grid-admin-cards">
        <!-- TARJETA DIRIGIDA AL DASHBOARD DE MÉTRICAS Y ANALÍTICA -->
        <div class="admin-card">
            <div>
                <div class="admin-card-icon">📈</div>
                <h3>Dashboard de Ventas</h3>
                <p>Consulta métricas de ingresos, reporte de visitas, tasa de conversión y gráficos de rendimiento.</p>
            </div>
            <!-- RUTA ACTUALIZADA A /admin/dashboard -->
            <a href="/proyecto_tejas/public/admin/dashboard" class="btn-card" style="background-color: #8e44ad;">Ver Estadísticas</a>
        </div>

        <!-- Tarjeta de Inventario / Gestión de Productos -->
        <div class="admin-card">
            <div>
                <div class="admin-card-icon">🧱</div>
                <h3>Gestión de Productos</h3>
                <p>Visualiza el inventario completo, modifica precios, actualiza stocks o elimina productos.</p>
            </div>
            <a href="/proyecto_tejas/public/producto/index" class="btn-card">Administrar Productos</a>
        </div>

        <!-- Tarjeta de Añadir Producto Rápidamente -->
        <div class="admin-card">
            <div>
                <div class="admin-card-icon">➕</div>
                <h3>Añadir Nuevo Producto</h3>
                <p>Registra de manera inmediata un nuevo producto especificando SKU, categoría, precio e imagen.</p>
            </div>
            <a href="/proyecto_tejas/public/producto/crear" class="btn-card" style="background-color: #27ae60;">Crear Producto</a>
        </div>

        <!-- Tarjeta de Vista de Catálogo -->
        <div class="admin-card">
            <div>
                <div class="admin-card-icon">🏬</div>
                <h3>Ver Catálogo Público</h3>
                <p>Accede a la vista del cliente para verificar cómo lucen las tejas y materiales publicados.</p>
            </div>
            <a href="/proyecto_tejas/public/catalogo/index" class="btn-card" style="background-color: #3498db;">Ir al Catálogo</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>