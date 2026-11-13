<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<style>
    .admin-container { max-width: 1100px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
    .btn-volver { background: #6c757d; color: white; padding: 10px 18px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem; }
    .btn-volver:hover { background: #5a6268; }
    .btn-restore { background: #27ae60; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
    .btn-restore:hover { background: #219150; }
    .btn-delete { background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.85rem; }
    .btn-delete:hover { background: #c0392b; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; vertical-align: middle; }
    th { background: #2c3e50; color: #fff; }
    .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    .badge-estado { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; }
    .badge-borrador { background: #ffeeba; color: #856404; }
    .badge-agotado { background: #f8d7da; color: #721c24; }
    .actions { display: flex; gap: 8px; align-items: center; }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h2>📁 Productos en Borrador o Agotados (Soft Delete)</h2>
        <a href="/proyecto_tejas/public/producto/index" class="btn-volver">⬅️ Volver a Productos Activos</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
            <?php
                if ($_GET['msg'] === 'restaurado_exito') echo "✅ Producto restaurado al catálogo con éxito.";
            ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Estado Actual</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($borradores)): ?>
                <?php foreach ($borradores as $p): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($p['sku']) ?></strong></td>
                    <td>
                        <img src="/proyecto_tejas/public/uploads/<?= htmlspecialchars($p['imagen']) ?>" class="img-thumb" alt="Teja" onerror="this.src='https://via.placeholder.com/50'">
                    </td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td>
                        <?php if ($p['estado'] === 'borrador'): ?>
                            <span class="badge-estado badge-borrador">Borrador</span>
                        <?php else: ?>
                            <span class="badge-estado badge-agotado">Agotado</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $p['stock'] ?> u.</td>
                    <td>$<?= number_format($p['precio'], 2) ?></td>
                    <td>
                        <div class="actions">
                            <!-- Botón para restaurar usando ruta limpia -->
                            <a href="/proyecto_tejas/public/producto/restaurar/<?= $p['id'] ?>" 
                               class="btn-restore" 
                               onclick="return confirm('¿Deseas restaurar este producto al catálogo activo?');">
                                ♻️ Restaurar
                            </a>

                            <!-- Botón para eliminar permanentemente si se desea -->
                            <form action="/proyecto_tejas/public/producto/eliminar/<?= $p['id'] ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar permanentemente este registro de la base de datos?')" style="display:inline;">
                                <button type="submit" class="btn-delete">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #777;">No hay productos en borrador o agotados actualmente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>