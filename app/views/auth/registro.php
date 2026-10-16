<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .register-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 35px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .register-card h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 1.6rem;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-size: 0.9rem;
            color: #4a5568;
            margin-bottom: 6px;
        }
        input, select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 0.95rem;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #27ae60;
        }
        .btn-submit {
            background-color: #27ae60;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background-color: #219150;
        }
        .login-link {
            text-align: center;
            margin-top: 18px;
            font-size: 0.9rem;
            color: #4a5568;
        }
        .login-link a {
            color: #27ae60;
            text-decoration: none;
            font-weight: bold;
        }

        /* RECUADRO INTERACTIVO DE REQUISITOS */
        .req-box {
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            margin-top: 8px;
        }
        .req-box p {
            margin: 0 0 6px 0;
            font-size: 0.8rem;
            font-weight: bold;
            color: #718096;
        }
        .req-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.8rem;
        }
        .req-list li {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h2>Crear Cuenta</h2>

        <?php if (!empty($error)): ?>
            <div style="background-color: #fed7d7; color: #9b2c2c; padding: 10px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 15px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/proyecto_tejas/public/auth/registro" method="POST">
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
                <input type="password" name="password" id="pass-input" required autocomplete="off">
                
                <!-- CAJA VISIBLE CON LOS REQUISITOS EN TIEMPO REAL -->
                <div class="req-box">
                    <p>Requisitos de la contraseña:</p>
                    <ul class="req-list">
                        <li id="req-length" style="color: #e53e3e;">❌ Mínimo 8 caracteres</li>
                        <li id="req-uppercase" style="color: #e53e3e;">❌ Al menos una letra mayúscula (A-Z)</li>
                        <li id="req-lowercase" style="color: #e53e3e;">❌ Al menos una letra minúscula (a-z)</li>
                        <li id="req-number" style="color: #e53e3e;">❌ Al menos un número (0-9)</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label>Tipo de Comprador:</label>
                <select name="tipo_cliente">
                    <option value="particular">Persona Particular</option>
                    <option value="empresa">Empresa / Contratista</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Registrarse</button>
        </form>

        <div class="login-link">
            ¿Ya tienes cuenta? <a href="/proyecto_tejas/public/auth/login">Inicia sesión</a>
        </div>
    </div>

    <!-- JS PARA ACTUALIZAR LOS INDICADORES MIENTRAS EL USUARIO ESCRIBE -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById('pass-input');
        if (!input) return;

        var reqLen = document.getElementById('req-length');
        var reqUpper = document.getElementById('req-uppercase');
        var reqLower = document.getElementById('req-lowercase');
        var reqNum = document.getElementById('req-number');

        function evaluar() {
            var val = input.value || '';

            var hasLen = val.length >= 8;
            var hasUpper = /[A-Z]/.test(val);
            var hasLower = /[a-z]/.test(val);
            var hasNum = /[0-9]/.test(val);

            actualizar(reqLen, hasLen, 'Mínimo 8 caracteres');
            actualizar(reqUpper, hasUpper, 'Al menos una letra mayúscula (A-Z)');
            actualizar(reqLower, hasLower, 'Al menos una letra minúscula (a-z)');
            actualizar(reqNum, hasNum, 'Al menos un número (0-9)');
        }

        function actualizar(el, ok, txt) {
            if (ok) {
                el.style.color = '#38a169';
                el.style.fontWeight = 'bold';
                el.innerHTML = '✔ ' + txt;
            } else {
                el.style.color = '#e53e3e';
                el.style.fontWeight = 'normal';
                el.innerHTML = '❌ ' + txt;
            }
        }

        input.addEventListener('keyup', evaluar);
        input.addEventListener('input', evaluar);
    });
    </script>
</body>
</html>