<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 1100px; background: #fff; margin: auto; padding: 20px; border-radius: 8px; }
        .btn { padding: 8px 12px; border-radius: 4px; text-decoration: none; color: #fff; font-size: 0.9rem; }
        .btn-add { background: #27ae60; float: right; margin-bottom: 15px; }
        .btn-edit { background: #f39c12; }
        .btn-delete { background: #e74c3c; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #2c3e50; color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestión de Usuarios</h2>
        <a href="/proyecto_tejas/public/usuario/crear" class="btn btn-add">+ Nuevo Usuario</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Tipo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><strong><?= htmlspecialchars($u['rol_nombre']) ?></strong></td>
                    <td><?= ucfirst($u['tipo_cliente']) ?></td>
                    <td><?= htmlspecialchars($u['telefono'] ?? 'N/A') ?></td>
                    <td style="display:flex; gap:5px;">
                        <a href="/proyecto_tejas/public/usuario/editar/<?= $u['id'] ?>" class="btn btn-edit">Editar</a>
                        <form action="/proyecto_tejas/public/usuario/eliminar/<?= $u['id'] ?>" method="POST" onsubmit="return confirm('¿Confirma eliminar este usuario?')">
                            <button type="submit" class="btn btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>