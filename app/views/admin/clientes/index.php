<?php 
if (file_exists(__DIR__ . '/../../layouts/header.php')) {
    require_once __DIR__ . '/../../layouts/header.php';
} elseif (file_exists(__DIR__ . '/../../../layouts/header.php')) {
    require_once __DIR__ . '/../../../layouts/header.php';
}
?>

<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .admin-container {
        max-width: 1100px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .admin-title {
        font-size: 1.8rem;
        color: #2c3e50;
        margin: 0;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .admin-table th {
        background-color: #34495e;
        color: #ffffff;
        padding: 12px;
        text-align: left;
        font-size: 0.9rem;
    }
    .admin-table td {
        padding: 12px;
        border-bottom: 1px solid #ecf0f1;
        font-size: 0.9rem;
        color: #2c3e50;
    }
    .btn-editar {
        background-color: #f39c12;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-editar:hover { background-color: #e67e22; }
    .btn-eliminar {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-eliminar:hover { background-color: #c0392b; }
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        align-items: center; justify-content: center;
    }
    .modal-content {
        background: white;
        padding: 25px;
        border-radius: 8px;
        width: 450px;
        max-width: 90%;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .form-group input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
</style>

<div class="admin-container">
    <div class="header-actions">
        <h1 class="admin-title">👥 Gestión de Clientes</h1>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th># ID</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clientes) && is_array($clientes)): ?>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><strong>#<?= htmlspecialchars($c['id']) ?></strong></td>
                        <td><?= htmlspecialchars($c['nombre'] . ' ' . $c['apellido']) ?></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        <td><?= htmlspecialchars($c['telefono'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($c['direccion'] ?? 'N/A') ?></td>
                        <td style="display: flex; gap: 5px;">
                            <button class="btn-editar" onclick='abrirModalEditar(<?= json_encode($c) ?>)'>Editar</button>
                            <form action="/proyecto_tejas/public/cliente/eliminar" method="POST" onsubmit="return confirm('¿Seguro de eliminar este cliente?');">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px; color:#7f8c8d;">
                        No hay clientes registrados en el sistema.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Editar Cliente -->
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <h2>Editar Cliente</h2>
        <form action="/proyecto_tejas/public/cliente/editar" method="POST">
            <input type="hidden" id="edit_id" name="id">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" id="edit_nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" id="edit_apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="edit_email" name="email" required>
            </div>
            <div class="form-group">
                <label>Nueva Contraseña (dejar en blanco para no cambiar):</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" id="edit_telefono" name="telefono">
            </div>
            <div class="form-group">
                <label>Dirección:</label>
                <input type="text" id="edit_direccion" name="direccion">
            </div>
            <div class="modal-actions">
                <button type="button" onclick="cerrarModal('modalEditar')">Cancelar</button>
                <button type="submit" class="btn-editar">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalEditar(cliente) {
        document.getElementById('edit_id').value = cliente.id;
        document.getElementById('edit_nombre').value = cliente.nombre;
        document.getElementById('edit_apellido').value = cliente.apellido;
        document.getElementById('edit_email').value = cliente.email;
        document.getElementById('edit_telefono').value = cliente.telefono || '';
        document.getElementById('edit_direccion').value = cliente.direccion || '';
        document.getElementById('modalEditar').style.display = 'flex';
    }

    function cerrarModal(idModal) {
        document.getElementById(idModal).style.display = 'none';
    }
</script>

<?php 
if (file_exists(__DIR__ . '/../../layouts/footer.php')) {
    require_once __DIR__ . '/../../layouts/footer.php';
} elseif (file_exists(__DIR__ . '/../../../layouts/header.php')) {
    require_once __DIR__ . '/../../../layouts/footer.php';
}
?>