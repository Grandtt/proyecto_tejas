<?php 
if (file_exists(__DIR__ . '/../../layouts/header.php')) {
    require_once __DIR__ . '/../../layouts/header.php';
} elseif (file_exists(__DIR__ . '/../../../layouts/header.php')) {
    require_once __DIR__ . '/../../../layouts/header.php';
}
?>

<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .admin-container {
        max-width: 1100px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .admin-title {
        font-size: 1.8rem;
        color: #2c3e50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .admin-table th {
        background-color: #34495e;
        color: #ffffff;
        padding: 12px;
        text-align: left;
        font-size: 0.9rem;
    }
    .admin-table td {
        padding: 12px;
        border-bottom: 1px solid #ecf0f1;
        font-size: 0.9rem;
        color: #2c3e50;
    }
    .select-estado {
        padding: 6px 10px;
        border-radius: 5px;
        border: 1px solid #bdc3c7;
        font-size: 0.85rem;
    }
    .btn-actualizar {
        background-color: #2980b9;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
    }
    .btn-actualizar:hover {
        background-color: #3498db;
    }
</style>

<div class="admin-container">
    <h1 class="admin-title">🛠️ Panel de Gestión de Pedidos (Administrador)</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th># Orden</th>
                <th>Cliente</th>
                <th>Dirección</th>
                <th>Total</th>
                <th>Método Pago</th>
                <th>Estado Actual</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pedidos) && is_array($pedidos)): ?>
                <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td><strong>#<?= htmlspecialchars($p['id']) ?></strong></td>
                        <td><?= htmlspecialchars(($p['nombre'] ?? '') . ' ' . ($p['apellido'] ?? '')) ?></td>
                        <td><?= htmlspecialchars($p['direccion_envio'] ?? 'N/A') ?></td>
                        <td>$<?= number_format($p['total'] ?? 0, 2) ?></td>
                        <td><?= htmlspecialchars(strtoupper($p['metodo_pago'] ?? 'Efectivo')) ?></td>
                        <td>
                            <form action="/proyecto_tejas/public/pedido/cambiarEstado" method="POST" style="display: flex; gap: 5px;">
                                <input type="hidden" name="pedido_id" value="<?= $p['id'] ?>">
                                <select name="estado_pedido" class="select-estado">
                                    <option value="pendiente" <?= ($p['estado_pedido'] ?? '') === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="enviado" <?= ($p['estado_pedido'] ?? '') === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                                    <option value="entregado" <?= ($p['estado_pedido'] ?? '') === 'entregado' ? 'selected' : '' ?>>Entregado</option>
                                    <option value="cancelado" <?= ($p['estado_pedido'] ?? '') === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                                <button type="submit" class="btn-actualizar">Guardar</button>
                            </form>
                        </td>
                        <td>
                            <span class="user-badge" style="background:#edf2f7; color:#2d3748; padding:4px 8px; border-radius:4px;">
                                Activo
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:20px; color:#7f8c8d;">
                        No hay pedidos registrados en el sistema.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
if (file_exists(__DIR__ . '/../../layouts/footer.php')) {
    require_once __DIR__ . '/../../layouts/footer.php';
} elseif (file_exists(__DIR__ . '/../../../layouts/footer.php')) {
    require_once __DIR__ . '/../../../layouts/footer.php';
}
?>