<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra - Tejas</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .box { max-width: 600px; background: #fff; margin: auto; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-confirm { background: #27ae60; color: #fff; padding: 12px; border: none; border-radius: 4px; width: 100%; font-size: 1rem; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Detalles de Envío y Pago</h2>
        <p><strong>Total a pagar: </strong><span style="color: #d35400;">$<?= number_format($total, 2) ?></span></p>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/proyecto_tejas/public/pedido/checkout" method="POST">
            <div class="form-group">
                <label>Dirección de Entrega (Obra o Domicilio):</label>
                <input type="text" name="direccion_envio" required placeholder="Ej: Av. Principal #45-12, Obra Residencial">
            </div>

            <div class="form-group">
                <label>Método de Pago:</label>
                <select name="metodo_pago" required>
                    <option value="transferencia">Transferencia Bancaria Directa</option>
                    <option value="efectivo">Pago Contra Entrega (Efectivo)</option>
                    <option value="pasarela">Tarjeta de Crédito / Pasarela</option>
                </select>
            </div>

            <button type="submit" class="btn-confirm">Confirmar y Generar Pedido</button>
        </form>
    </div>
</body>
</html>