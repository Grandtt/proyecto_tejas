<?php 
if (file_exists(__DIR__ . '/../layouts/header.php')) {
    require_once __DIR__ . '/../layouts/header.php';
} elseif (file_exists(__DIR__ . '/../../layouts/header.php')) {
    require_once __DIR__ . '/../../layouts/header.php';
}
?>

<div style="max-width: 1000px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #e67e22; padding-bottom: 10px; margin-top: 0;">
        📦 Estado y Seguimiento de Mis Pedidos
    </h2>

    <?php if (empty($pedidos)): ?>
        <p style="text-align: center; color: #7f8c8d; padding: 40px 0; font-size: 1rem;">No tienes pedidos registrados en este momento.</p>
        <div style="text-align: center;">
            <a href="/proyecto_tejas/public/catalogo/index" style="background: #e67e22; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Ir al Catálogo</a>
        </div>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6; text-align: left;">
                    <th style="padding: 12px; color: #2c3e50;"># Orden</th>
                    <th style="padding: 12px; color: #2c3e50;">Fecha</th>
                    <th style="padding: 12px; color: #2c3e50;">Total</th>
                    <th style="padding: 12px; color: #2c3e50;">Dirección</th>
                    <th style="padding: 12px; color: #2c3e50;">Método Pago</th>
                    <th style="padding: 12px; color: #2c3e50;">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $p): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; font-weight: bold; color: #e67e22;">#<?= htmlspecialchars($p['id']) ?></td>
                    <td style="padding: 12px; color: #555;"><?= htmlspecialchars($p['created_at'] ?? 'N/A') ?></td>
                    <td style="padding: 12px; color: #27ae60; font-weight: bold;">$<?= number_format((float)$p['total'], 2) ?></td>
                    <td style="padding: 12px; color: #555;"><?= htmlspecialchars($p['direccion_envio']) ?></td>
                    <td style="padding: 12px; color: #555;"><?= htmlspecialchars(strtoupper($p['metodo_pago'])) ?></td>
                    <td style="padding: 12px;">
                        <span style="background: #34495e; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">
                            <?= htmlspecialchars(ucfirst($p['estado_pedido'])) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php 
if (file_exists(__DIR__ . '/../layouts/footer.php')) {
    require_once __DIR__ . '/../layouts/footer.php';
} elseif (file_exists(__DIR__ . '/../../layouts/footer.php')) {
    require_once __DIR__ . '/../../layouts/footer.php';
}
?>