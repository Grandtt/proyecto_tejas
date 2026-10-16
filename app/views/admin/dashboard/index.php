<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<style>
    .dashboard-container {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 15px;
    }
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .metric-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 5px solid #2980b9;
    }
    .metric-card.green { border-left-color: #27ae60; }
    .metric-card.orange { border-left-color: #e67e22; }
    .metric-card.purple { border-left-color: #8e44ad; }
    
    .metric-card h4 {
        margin: 0 0 10px 0;
        font-size: 0.85rem;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .metric-card .value {
        font-size: 1.8rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .table-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .table-container h3 {
        margin-top: 0;
        margin-bottom: 15px;
        color: #2c3e50;
    }
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }
    .table-custom th, .table-custom td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    .table-custom th {
        background-color: #f8f9fa;
        color: #2c3e50;
    }
    .badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: bold;
        background-color: #27ae60;
        color: white;
    }
</style>

<div class="dashboard-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2>📊 Dashboard de Estadísticas</h2>
        <a href="/proyecto_tejas/public/admin/index" style="text-decoration: none; font-weight: bold; color: #3498db;">← Volver al Panel de Control</a>
    </div>

    <!-- TARJETAS DE MÉTRICAS GENERALES -->
    <div class="metrics-grid">
        <div class="metric-card green">
            <h4>Total Ingresos</h4>
            <p class="value">$<?= number_format($totalVentas ?? 0, 0, ',', '.') ?></p>
        </div>
        <div class="metric-card orange">
            <h4>Total Pedidos</h4>
            <p class="value"><?= $totalPedidos ?? 0 ?></p>
        </div>
        <div class="metric-card purple">
            <h4>Clientes Registrados</h4>
            <p class="value"><?= $totalClientes ?? 0 ?></p>
        </div>
        <div class="metric-card">
            <h4>Productos en Catálogo</h4>
            <p class="value"><?= $totalProductos ?? 0 ?></p>
        </div>
    </div>

    <!-- TABLA DE MOVIMIENTOS Y TRANSACCIONES -->
    <div class="table-container">
        <h3>Últimas Transacciones</h3>
        <table class="table-custom">
            <thead>
                <tr>
                    <th>N° Pedido</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ultimasVentas)): ?>
                    <?php foreach ($ultimasVentas as $venta): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($venta['id']) ?></td>
                            <td><?= htmlspecialchars($venta['cliente']) ?></td>
                            <td><strong>$<?= number_format($venta['total'], 0, ',', '.') ?></strong></td>
                            <td><span class="badge"><?= htmlspecialchars(ucfirst($venta['estado'])) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #7f8c8d; padding: 20px;">
                            No hay registros de pedidos disponibles en la base de datos.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>