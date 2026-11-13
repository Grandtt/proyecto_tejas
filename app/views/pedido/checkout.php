<?php 
if (file_exists(__DIR__ . '/../layouts/header.php')) {
    require_once __DIR__ . '/../layouts/header.php';
} elseif (file_exists(__DIR__ . '/../../layouts/header.php')) {
    require_once __DIR__ . '/../../layouts/header.php';
}
?>

<div style="max-width: 700px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #e67e22; padding-bottom: 10px; margin-top: 0;">
        🧾 Confirmar Pedido y Pago
    </h2>

    <?php 
        $carrito = $_SESSION['carrito'] ?? [];
        $total = 0;
    ?>

    <?php if (empty($carrito)): ?>
        <p style="color: #7f8c8d; text-align: center; padding: 20px 0;">Tu carrito está vacío. Agrega productos antes de finalizar la compra.</p>
        <div style="text-align: center;">
            <a href="/proyecto_tejas/public/catalogo/index" style="display: inline-block; background: #e67e22; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Volver al Catálogo</a>
        </div>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6; text-align: left;">
                    <th style="padding: 10px;">Producto</th>
                    <th style="padding: 10px;">Cant.</th>
                    <th style="padding: 10px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $item): 
                    $subtotal = (float)$item['precio'] * (int)$item['cantidad'];
                    $total += $subtotal;
                ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px; color: #2c3e50; font-weight: bold;"><?= htmlspecialchars($item['nombre']) ?></td>
                    <td style="padding: 10px; color: #555;"><?= (int)$item['cantidad'] ?></td>
                    <td style="padding: 10px; color: #27ae60; font-weight: bold;">$<?= number_format($subtotal, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 style="text-align: right; color: #2c3e50;">Total a Pagar: <span style="color: #e67e22;">$<?= number_format($total, 2) ?></span></h3>

        <!-- IMPORTANTE: El action apunta directamente a la ruta del checkout en el controlador -->
        <form action="/proyecto_tejas/public/pedido/checkout" method="POST" style="margin-top: 25px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2c3e50;">Dirección de Entrega:</label>
                <input type="text" name="direccion_entrega" required placeholder="Ej: Calle 123 # 45 - 67, Bogotá" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2c3e50;">Método de Pago:</label>
                <select name="metodo_pago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #fff;">
                    <option value="contra entrega">🚚 Pago Contra Entrega</option>
                    <option value="nequi">📱 Transferencia Nequi</option>
                    <option value="transferencia">🏦 Transferencia Bancaria</option>
                </select>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="/proyecto_tejas/public/carrito/index" style="color: #7f8c8d; text-decoration: none;">← Volver al carrito</a>
                <button type="submit" style="background: #27ae60; color: white; border: none; padding: 12px 24px; border-radius: 5px; font-size: 1rem; font-weight: bold; cursor: pointer;">
                    ✅ Confirmar y Finalizar Compra
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php 
if (file_exists(__DIR__ . '/../layouts/footer.php')) {
    require_once __DIR__ . '/../layouts/footer.php';
} elseif (file_exists(__DIR__ . '/../../layouts/footer.php')) {
    require_once __DIR__ . '/../../layouts/footer.php';
}
?>