<?php 
if (file_exists(__DIR__ . '/../layouts/header.php')) {
    require_once __DIR__ . '/../layouts/header.php';
} elseif (file_exists(__DIR__ . '/../../layouts/header.php')) {
    require_once __DIR__ . '/../../layouts/header.php';
}
?>

<style>
    body {
        background-color: #f8f9fa;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        margin: 0;
        padding: 0;
    }
    .seguimiento-card {
        max-width: 950px;
        margin: 40px auto;
        background: #ffffff;
        padding: 35px 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    .seguimiento-titulo {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 25px;
    }
    .seguimiento-tabla {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .seguimiento-tabla th {
        font-size: 0.95rem;
        font-weight: 700;
        color: #2d3748;
        padding: 12px 10px;
        border-bottom: 2px solid #edf2f7;
    }
    .seguimiento-tabla td {
        font-size: 0.9rem;
        color: #4a5568;
        padding: 16px 10px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
    }
    .badge-estado {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .estado-pendiente { background-color: #fff3cd; color: #856404; }
    .estado-enviado   { background-color: #cce5ff; color: #004085; }
    .estado-entregado { background-color: #d4edda; color: #155724; }
    .estado-cancelado { background-color: #f8d7da; color: #721c24; }
    .sin-pedidos {
        text-align: center;
        color: #a0aec0;
        padding: 30px 0;
    }
</style>

<div class="seguimiento-card">
    <h1 class="seguimiento-titulo">Estado y Seguimiento de Mis Pedidos</h1>

    <table class="seguimiento-tabla">
        <thead>
            <tr>
                <th># Orden</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Dirección</th>
                <th>Estado de Envío</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pedidos) && is_array($pedidos)): ?>
                <?php foreach ($pedidos as $pedido): ?>
                    <?php 
                        $id = $pedido['id'] ?? 'N/A';
                        $rawFecha = $pedido['created_at'] ?? $pedido['fecha'] ?? null;
                        $fecha = $rawFecha ? date('d/m/Y', strtotime($rawFecha)) : 'Sin fecha';
                        $total = isset($pedido['total']) ? '$' . number_format($pedido['total'], 2) : '$0.00';
                        $direccion = $pedido['direccion_envio'] ?? $pedido['direccion'] ?? 'No registrada';
                        $estadoRaw = strtolower($pedido['estado_pedido'] ?? $pedido['estado'] ?? 'pendiente');
                        
                        $claseBadge = 'estado-pendiente';
                        if (in_array($estadoRaw, ['enviado', 'en camino'])) {
                            $claseBadge = 'estado-enviado';
                        } elseif (in_array($estadoRaw, ['entregado', 'completado'])) {
                            $claseBadge = 'estado-entregado';
                        } elseif ($estadoRaw === 'cancelado') {
                            $claseBadge = 'estado-cancelado';
                        }
                    ?>
                    <tr>
                        <td><strong>#<?= htmlspecialchars($id) ?></strong></td>
                        <td><?= htmlspecialchars($fecha) ?></td>
                        <td><?= htmlspecialchars($total) ?></td>
                        <td><?= htmlspecialchars($direccion) ?></td>
                        <td>
                            <span class="badge-estado <?= $claseBadge ?>">
                                <?= htmlspecialchars(ucfirst($estadoRaw)) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="sin-pedidos">
                        No tienes pedidos registrados en este momento.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
if (file_exists(__DIR__ . '/../layouts/footer.php')) {
    require_once __DIR__ . '/../layouts/footer.php';
} elseif (file_exists(__DIR__ . '/../../layouts/footer.php')) {
    require_once __DIR__ . '/../../layouts/footer.php';
}
?>