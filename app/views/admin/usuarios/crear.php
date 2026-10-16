<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .form-box { max-width: 500px; background: #fff; margin: auto; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background: #27ae60; color: #fff; padding: 10px; border: none; border-radius: 4px; width: 100%; cursor: pointer; font-size: 1rem; font-weight: bold; margin-top: 10px; }
        .btn-submit:hover { background: #219150; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; border: 1px solid #f5c6cb; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Registrar Nuevo Usuario</h2>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

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
            
            <!-- CAMPO DE CONTRASEÑA CON CAJA DE REQUISITOS INTEGRADA -->
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" id="pass-input" required autocomplete="off">
                
                <!-- RECUADRO CON ESTILOS EN LÍNEA PARA EVITAR OCULTAMIENTO -->
                <div id="caja-requisitos" style="display: block; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 8px;">
                    <p style="margin: 0 0 5px 0; font-size: 13px; font-weight: bold; color: #333;">La contraseña debe contener:</p>
                    <ul style="list-style: none; padding-left: 5px; margin: 0; font-size: 13px;">
                        <li id="req-length" style="color: #e74c3c; margin-bottom: 3px;">❌ Mínimo 8 caracteres</li>
                        <li id="req-uppercase" style="color: #e74c3c; margin-bottom: 3px;">❌ Al menos una letra mayúscula (A-Z)</li>
                        <li id="req-lowercase" style="color: #e74c3c; margin-bottom: 3px;">❌ Al menos una letra minúscula (a-z)</li>
                        <li id="req-number" style="color: #e74c3c; margin-bottom: 3px;">❌ Al menos un número (0-9)</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label>Rol de Usuario:</label>
                <select name="role_id" required>
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $r): ?>
                            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nombre']) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="2">Cliente</option>
                    <?php endif; ?>
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

    <!-- SCRIPT DIRECTO -->
    <script>
        var passInput = document.getElementById('pass-input');
        
        if (passInput) {
            passInput.addEventListener('keyup', evaluarPassword);
            passInput.addEventListener('input', evaluarPassword);
        }

        function evaluarPassword() {
            var val = passInput.value || '';

            var reqLen = document.getElementById('req-length');
            var reqUpper = document.getElementById('req-uppercase');
            var reqLower = document.getElementById('req-lowercase');
            var reqNum = document.getElementById('req-number');

            // Evaluaciones
            var hasLen = val.length >= 8;
            var hasUpper = /[A-Z]/.test(val);
            var hasLower = /[a-z]/.test(val);
            var hasNum = /[0-9]/.test(val);

            // Actualizar 8 caracteres
            actualizarElemento(reqLen, hasLen, 'Mínimo 8 caracteres');
            
            // Actualizar Mayúscula
            actualizarElemento(reqUpper, hasUpper, 'Al menos una letra mayúscula (A-Z)');
            
            // Actualizar Minúscula
            actualizarElemento(reqLower, hasLower, 'Al menos una letra minúscula (a-z)');
            
            // Actualizar Número
            actualizarElemento(reqNum, hasNum, 'Al menos un número (0-9)');
        }

        function actualizarElemento(el, esValido, texto) {
            if (esValido) {
                el.style.color = '#27ae60';
                el.style.fontWeight = 'bold';
                el.innerHTML = '✔ ' + texto;
            } else {
                el.style.color = '#e74c3c';
                el.style.fontWeight = 'normal';
                el.innerHTML = '❌ ' + texto;
            }
        }
    </script>
</body>
</html>