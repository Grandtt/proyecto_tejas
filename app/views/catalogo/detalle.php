<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($producto['nombre']) ?> - Ficha Técnica</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .detail-card { max-width: 900px; background: #fff; margin: auto; padding: 25px; border-radius: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .detail-card img { width: 100%; border-radius: 8px; }
        .tech-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .tech-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .btn-cart { background: #d35400; color: #fff; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <div class="detail-card">
        <div>
            <img src="/proyecto_tejas/public/img/productos/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" onerror="this.src='/proyecto_tejas/public/img/productos/default_producto.jpg'">
        </div>
        <div>
            <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
            <p><?= htmlspecialchars($producto['descripcion']) ?></p>
            <h3 style="color: #d35400;">$<?= number_format($producto['precio'], 2) ?> c/u</h3>

            <h4>Especificaciones Técnicas:</h4>
            <table class="tech-table">
                <tr><td><strong>Material:</strong></td><td><?= ucfirst($producto['material']) ?></td></tr>
                <tr><td><strong>Dimensiones:</strong></td><td><?= htmlspecialchars($producto['dimensiones'] ?? 'N/A') ?></td></tr>
                <tr><td><strong>Peso:</strong></td><td><?= $producto['peso_kg'] ? $producto['peso_kg'] . ' Kg' : 'N/A' ?></td></tr>
                <tr><td><strong>Rendimiento por m²:</strong></td><td><?= $producto['rendimiento_m2'] ? $producto['rendimiento_m2'] . ' tejas' : 'N/A' ?></td></tr>
                <tr><td><strong>Resistencia:</strong></td><td><?= htmlspecialchars($producto['resistencia'] ?? 'Estándar') ?></td></tr>
            </table>

            <form action="/proyecto_tejas/public/carrito/agregar" method="POST">
                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                <div style="margin-bottom: 15px;">
                    <label><strong>Cantidad deseada:</strong></label>
                    <input type="number" name="cantidad" value="1" min="1" max="<?= $producto['stock'] ?>" style="padding: 8px; width: 80px;">
                </div>
                <button type="submit" class="btn-cart">Añadir al Carrito</button>
            </form>
        </div>
    </div>
</body>
</html>