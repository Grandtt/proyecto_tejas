<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<style>
    .admin-container { max-width: 1100px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .btn-add { background: #27ae60; color: white; padding: 10px 18px; border-radius: 5px; text-decoration: none; font-weight: bold; }
    .btn-add:hover { background: #219150; }
    .btn-edit { background: #f39c12; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
    .btn-delete { background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.85rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; vertical-align: middle; }
    th { background: #2c3e50; color: #fff; }
    .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    .actions { display: flex; gap: 8px; }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h2>Panel de Administración: Gestión de Productos</h2>
        <a href="/proyecto_tejas/public/producto/crear" class="btn-add">➕ Añadir Nuevo Producto</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
            <?php
                if ($_GET['msg'] === 'creado') echo "✅ Producto añadido correctamente.";
                if ($_GET['msg'] === 'actualizado') echo "✏️ Producto actualizado correctamente.";
                if ($_GET['msg'] === 'eliminado') echo "🗑️ Producto eliminado del sistema.";
            ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($p['sku']) ?></strong></td>
                    <td>
                        <img src="/proyecto_tejas/public/uploads/<?= htmlspecialchars($p['imagen']) ?>" class="img-thumb" alt="Teja" onerror="this.src='https://via.placeholder.com/50'">
                    </td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['categoria_nombre']) ?></td>
                    <td>$<?= number_format($p['precio'], 2) ?></td>
                    <td><?= $p['stock'] ?> u.</td>
                    <td>
                        <div class="actions">
                            <a href="/proyecto_tejas/public/producto/editar/<?= $p['id'] ?>" class="btn-edit">Modificar</a>
                            <form action="/proyecto_tejas/public/producto/eliminar/<?= $p['id'] ?>" method="POST" onsubmit="return confirm('¿Confirma que desea eliminar este producto?')">
                                <button type="submit" class="btn-delete">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #777;">No hay productos registrados actualmente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>