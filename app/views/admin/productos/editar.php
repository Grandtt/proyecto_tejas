<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .form-box { max-width: 600px; background: #fff; margin: auto; padding: 25px; border-radius: 8px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .form-group { margin-bottom: 12px; }
        .full-width { grid-column: span 2; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background: #3498db; color: #fff; padding: 10px; border: none; border-radius: 4px; width: 100%; cursor: pointer; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Editar Producto #<?= $producto['id'] ?></h2>
        <form action="/proyecto_tejas/public/producto/editar/<?= $producto['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="grid">
                <div class="form-group">
                    <label>SKU:</label>
                    <input type="text" name="sku" value="<?= htmlspecialchars($producto['sku']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Categoría:</label>
                    <select name="categoria_id" required>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $c['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label>Nombre del Producto:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Precio ($):</label>
                    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Stock:</label>
                    <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Material:</label>
                    <input type="text" name="material" value="<?= htmlspecialchars($producto['material']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Resistencia:</label>
                    <input type="text" name="resistencia" value="<?= htmlspecialchars($producto['resistencia'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Dimensiones:</label>
                    <input type="text" name="dimensiones" value="<?= htmlspecialchars($producto['dimensiones'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Peso (kg):</label>
                    <input type="number" step="0.01" name="peso_kg" value="<?= $producto['peso_kg'] ?>">
                </div>
                <div class="form-group">
                    <label>Rendimiento (unidades por m²):</label>
                    <input type="number" step="0.01" name="rendimiento_m2" value="<?= $producto['rendimiento_m2'] ?>">
                </div>
                <div class="form-group full-width">
                    <label>Cambiar Imagen (opcional):</label>
                    <input type="file" name="imagen" accept="image/*">
                </div>
                <div class="form-group full-width">
                    <label>Descripción:</label>
                    <textarea name="descripcion" rows="3"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn-submit">Actualizar Producto</button>
        </form>
    </div>
</body>
</html>