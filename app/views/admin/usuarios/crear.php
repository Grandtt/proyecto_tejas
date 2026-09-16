<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .form-box { max-width: 500px; background: #fff; margin: auto; padding: 25px; border-radius: 8px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background: #27ae60; color: #fff; padding: 10px; border: none; border-radius: 4px; width: 100%; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Registrar Nuevo Usuario</h2>
        <form action="/proyecto_tejas/public/usuario/crear" method="POST">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Rol de Usuario:</label>
                <select name="role_id" required>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tipo de Cliente:</label>
                <select name="tipo_cliente">
                    <option value="particular">Particular</option>
                    <option value="empresa">Empresa / Contratista</option>
                </select>
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono">
            </div>
            <div class="form-group">
                <label>Dirección:</label>
                <input type="text" name="direccion">
            </div>
            <button type="submit" class="btn-submit">Guardar Usuario</button>
        </form>
    </div>
</body>
</html>