<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<style>
    .form-container {
        max-width: 700px;
        margin: 20px auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .form-container h2 {
        color: #2c3e50;
        margin-bottom: 20px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #34495e;
    }
    .form-group input, 
    .form-group select, 
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.95rem;
    }
    .form-row {
        display: flex;
        gap: 15px;
    }
    .form-row .form-group {
        flex: 1;
    }
    .btn-submit {
        background-color: #27ae60;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
    }
    .btn-submit:hover {
        background-color: #219150;
    }
    .btn-cancel {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #7f8c8d;
        text-decoration: none;
    }
</style>

<div class="form-container">
    <h2>Añadir Nuevo Producto</h2>

    <form action="/proyecto_tejas/public/producto/guardar" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label for="sku">SKU (Código único):</label>
                <input type="text" id="sku" name="sku" placeholder="Ej: TEJ-BAR-01" required>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoría:</label>
                <select id="categoria_id" name="categoria_id" required>
                    <option value="">-- Selecciona una categoría --</option>
                    <?php if (!empty($categorias)): ?>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Opciones por defecto si la consulta viene vacía -->
                        <option value="1">Tejas de Barro</option>
                        <option value="2">Tejas Termoacústicas</option>
                        <option value="3">Tejas de Policarbonato</option>
                        <option value="4">Tejas de Fibrocemento</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej: Teja Española Barro Cocido" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="material">Material:</label>
                <input type="text" id="material" name="material" placeholder="Ej: Barro / Arcilla" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio ($):</label>
                <input type="number" step="0.01" id="precio" name="precio" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock Disponible:</label>
                <input type="number" id="stock" name="stock" placeholder="100" required>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción / Especificaciones:</label>
            <textarea id="descripcion" name="descripcion" rows="4" placeholder="Detalles de rendimiento por m², resistencia, etc."></textarea>
        </div>

        <div class="form-group">
            <label for="imagen">Imagen del Producto:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Guardar Producto</button>
        <a href="/proyecto_tejas/public/producto/index" class="btn-cancel">Cancelar y Volver</a>
    </form>
</div>
<div class="form-group">
    <label for="categoria_id">Categoría:</label>
    <select id="categoria_id" name="categoria_id" required>
        <option value="">-- Selecciona una categoría --</option>
        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>

<?php require_once __DIR__ . '/../../layouts/header.php'; ?>