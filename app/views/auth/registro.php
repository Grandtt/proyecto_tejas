<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tejas e-Commerce</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: .5rem; color: #555; }
        input, select { width: 100%; padding: .75rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: .75rem; background: #27ae60; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn:hover { background: #2ecc71; }
        .alert { padding: .75rem; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 1rem; }
        .footer-link { text-align: center; margin-top: 1rem; font-size: .9rem; }
        .footer-link a { color: #27ae60; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Crear Cuenta</h2>

        <?php if (!empty($error)): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/proyecto_tejas/public/auth/registro" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="tipo_cliente">Tipo de Comprador:</label>
                <select id="tipo_cliente" name="tipo_cliente">
                    <option value="particular">Persona Particular</option>
                    <option value="empresa">Empresa Constructora</option>
                </select>
            </div>
            <button type="submit" class="btn">Registrarse</button>
        </form>

        <div class="footer-link">
            ¿Ya tienes cuenta? <a href="/proyecto_tejas/public/auth/login">Inicia sesión</a>
        </div>
    </div>
</body>
</html>