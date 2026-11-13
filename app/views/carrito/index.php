<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #e67e22; padding-bottom: 10px; margin-top: 0;">
        🛒 Tu Carrito de Compras
    </h2>

    <?php if (empty($items)): ?>
        <p style="text-align: center; color: #7f8c8d; padding: 40px 0;">Tu carrito está actualmente vacío.</p>
        <div style="text-align: center;">
            <a href="/proyecto_tejas/public/catalogo/index" style="background: #e67e22; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Ver Catálogo de Productos</a>
        </div>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6; text-align: left;">
                    <th style="padding: 12px;">Producto</th>
                    <th style="padding: 12px;">Precio Unitario</th>
                    <th style="padding: 12px;">Cantidad</th>
                    <th style="padding: 12px;">Subtotal</th>
                    <th style="padding: 12px; text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $id => $item): 
                    $subtotal = $item['precio'] * $item['cantidad'];
                ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; font-weight: bold; color: #2c3e50;"><?= htmlspecialchars($item['nombre']) ?></td>
                    <td style="padding: 12px; color: #555;">$<?= number_format($item['precio'], 2) ?></td>
                    <td style="padding: 12px; color: #555;"><?= (int)$item['cantidad'] ?></td>
                    <td style="padding: 12px; color: #27ae60; font-weight: bold;">$<?= number_format($subtotal, 2) ?></td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="/proyecto_tejas/public/carrito/eliminar/<?= $id ?>" style="background: #e74c3c; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem;">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
            <a href="/proyecto_tejas/public/carrito/vaciar" style="background: #95a5a6; color: white; padding: 10px 15px; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">Vaciar Carrito</a>
            <h3 style="color: #2c3e50; margin: 0;">Total General: <span style="color: #27ae60;">$<?= number_format($total, 2) ?></span></h3>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <a href="/proyecto_tejas/public/pedido/checkout" style="background: #27ae60; color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; font-size: 1rem; font-weight: bold;">Proceder al Pago →</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>