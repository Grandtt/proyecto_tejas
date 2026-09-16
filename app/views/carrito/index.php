<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras - Tejas</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .cart-container { max-width: 850px; background: #fff; margin: auto; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .total-box { text-align: right; font-size: 1.3rem; margin-bottom: 20px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 4px; color: #fff; font-weight: bold; }
        .btn-checkout { background: #27ae60; }
        .btn-danger { background: #e74c3c; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Carrito de Compras</h2>
        
        <?php if (empty($items)): ?>
            <p>El carrito está vacío. <a href="/proyecto_tejas/public/catalogo/index">Ir al catálogo</a></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre']) ?><br><small>SKU: <?= $item['sku'] ?></small></td>
                        <td>$<?= number_format($item['precio'], 2) ?></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                        <td><a href="/proyecto_tejas/public/carrito/eliminar/<?= $item['id'] ?>" class="btn btn-danger">Quitar</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-box">
                <strong>Total Pedido: </strong> <span style="color: #d35400;">$<?= number_format($total, 2) ?></span>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <a href="/proyecto_tejas/public/carrito/vaciar" class="btn btn-danger">Vaciar Carrito</a>
                <a href="/proyecto_tejas/public/pedido/checkout" class="btn btn-checkout">Proceder a la Compra / Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>