<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<style>
    .admin-container { max-width: 1100px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
    .admin-header-actions { display: flex; gap: 10px; align-items: center; }
    .btn-add { background: #27ae60; color: white; padding: 10px 18px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem; }
    .btn-add:hover { background: #219150; }
    .btn-borradores { background: #6c757d; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem; }
    .btn-borradores:hover { background: #5a6268; }
    .btn-edit { background: #f39c12; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
    .btn-edit:hover { background: #e67e22; }
    .btn-archive { background: #e67e22; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; border: none; cursor: pointer; }
    .btn-archive:hover { background: #d35400; }
    .btn-delete { background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.85rem; }
    .btn-delete:hover { background: #c0392b; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; vertical-align: middle; }
    th { background: #2c3e50; color: #fff; }
    .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    .actions { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
</style>

<div class="admin-container">
    
    <!-- Alerta de Stock Bajo -->
    <?php if (!empty($alertasStock)): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <h4 style="margin-bottom: 5px;">⚠️ Alerta de Stock Bajo</h4>
            <p style="font-size: 0.9rem; margin-bottom: 8px;">Los siguientes productos tienen un inventario crítico (5 unidades o menos):</p>
            <ul style="margin-left: 20px; font-size: 0.85rem;">
                <?php foreach ($alertasStock as $alerta): ?>
                    <li><strong><?= htmlspecialchars($alerta['nombre']); ?></strong> (SKU: <?= htmlspecialchars($alerta['sku']); ?>) - Quedan solo <strong><?= $alerta['stock']; ?></strong> unidades.</li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="admin-header">
        <h2>Panel de Administración: Gestión de Productos</h2>
        <div class="admin-header-actions">
            <a href="/proyecto_tejas/public/producto/borradores" class="btn-borradores">📁 Ver Borradores / Agotados</a>
            <a href="/proyecto_tejas/public/producto/crear" class="btn-add">➕ Añadir Nuevo Producto</a>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 12px; border-radius: 5px; margin-bottom: 15px; background: <?= $_GET['msg'] === 'error' ? '#f8d7da' : '#d4edda'; ?>; color: <?= $_GET['msg'] === 'error' ? '#721c24' : '#155724'; ?>; border: 1px solid <?= $_GET['msg'] === 'error' ? '#f5c6cb' : '#c3e6cb'; ?>;">
            <?php
                if ($_GET['msg'] === 'creado') echo "✅ Producto añadido correctamente.";
                if ($_GET['msg'] === 'actualizado') echo "✏️ Producto actualizado correctamente.";
                if ($_GET['msg'] === 'eliminado') echo "🗑️ Producto eliminado del sistema con éxito.";
                if ($_GET['msg'] === 'borrador_exito') echo "📥 Producto enviado a borradores correctamente.";
                if ($_GET['msg'] === 'error') echo "⚠️ Ocurrió un error al procesar la acción con el producto.";
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
                    <td><?= htmlspecialchars($p['categoria_nombre'] ?? 'General') ?></td>
                    <td>$<?= number_format($p['precio'], 2) ?></td>
                    <td>
                        <span style="font-weight: bold; color: <?= $p['stock'] <= 5 ? '#e74c3c' : '#2c3e50'; ?>;">
                            <?= $p['stock'] ?> u.
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="/proyecto_tejas/public/producto/editar/<?= $p['id'] ?>" class="btn-edit">Modificar</a>
                            
                            <a href="/proyecto_tejas/public/producto/enviarBorrador/<?= $p['id'] ?>" 
                               onclick="return confirm('¿Deseas ocultar este producto del catálogo y enviarlo a borradores?');" 
                               class="btn-archive" title="Ocultar del catálogo">
                                Archivar
                            </a>

                            <form action="/proyecto_tejas/public/producto/eliminar/<?= $p['id'] ?>" method="POST" onsubmit="return confirm('¿Confirma que desea eliminar permanentemente este producto?')" style="display:inline;">
                                <button type="submit" class="btn-delete">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #777;">No hay productos activos registrados actualmente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
