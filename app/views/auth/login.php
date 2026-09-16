<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Tejas e-Commerce</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: .5rem; color: #555; }
        input[type="email"], input[type="password"] { width: 100%; padding: .75rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: .75rem; background: #d35400; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn:hover { background: #e67e22; }
        .alert { padding: .75rem; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 1rem; font-size: .9rem; }
        .alert-success { background: #d4edda; color: #155724; }
        .footer-link { text-align: center; margin-top: 1rem; font-size: .9rem; }
        .footer-link a { color: #d35400; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Ingreso a la Plataforma</h2>

        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok'): ?>
            <div class="alert alert-success">Registro exitoso. Ahora puedes iniciar sesión.</div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/proyecto_tejas/public/auth/login" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>

        <div class="footer-link">
            ¿No tienes una cuenta? <a href="/proyecto_tejas/public/auth/registro">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>