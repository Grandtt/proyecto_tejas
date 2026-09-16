<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    .catalogo-container { max-width: 1200px; margin: 0 auto; padding: 10px; }
    .catalogo-header { margin-bottom: 25px; text-align: center; }
    .catalogo-header h2 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; }
    
    /* Filtros */
    .filtros-box { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
    .filtros-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end; }
    .filtros-form label { font-weight: bold; font-size: 0.9rem; display: block; margin-bottom: 5px; }
    .filtros-form select, .filtros-form input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    .btn-filtrar { background: #3498db; color: #fff; border: none; padding: 10px; border-radius: 4px; font-weight: bold; cursor: pointer; }
    .btn-filtrar:hover { background: #2980b9; }

    /* Grid de Productos */
    .grid-productos { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px; }
    .card-producto { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s; }
    .card-producto:hover { transform: translateY(-4px); }
    .card-img { width: 100%; height: 180px; object-fit: cover; }
    .card-body { padding: 15px; flex-grow: 1; }
    .card-badge { background: #e8f4fd; color: #2980b9; font-size: 0.8rem; font-weight: bold; padding: 4px 8px; border-radius: 4px; display: inline-block; margin-bottom: 8px; }
    .card-title { font-size: 1.1rem; color: #2c3e50; margin: 0 0 8px 0; }
    .card-price { font-size: 1.3rem; font-weight: bold; color: #27ae60; margin-bottom: 10px; }
    .card-info { font-size: 0.85rem; color: #666; margin-bottom: 5px; }
    .card-footer { padding: 15px; background: #fafafa; border-top: 1px solid #eee; text-align: center; }
    .btn-detalle { background: #2c3e50; color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-size: 0.9rem; display: block; text-align: center; }
    .btn-detalle:hover { background: #1a252f; }
</style>

<div class="catalogo-container">
    <div class="catalogo-header">
        <h2>Catálogo de Tejas y Materiales</h2>
        <p>Selecciona y explora los materiales para tus proyectos de construcción.</p>
    </div>

    <!-- Barra de Filtros -->
    <div class="filtros-box">
        <form action="/proyecto_tejas/public/catalogo/index" method="GET" class="filtros-form">
            <div>
                <label>Categoría:</label>
                <select name="categoria_id">
                    <option value="">Todas las categorías</option>
                    <?php if (!empty($categorias)): ?>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= isset($_GET['categoria_id']) && $_GET['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div>
                <label>Material:</label>
                <input type="text" name="material" placeholder="Ej: Barro, PVC, Fibrocemento" value="<?= htmlspecialchars($_GET['material'] ?? '') ?>">
            </div>
            <div>
                <label>Precio Máximo ($):</label>
                <input type="number" step="0.01" name="precio_max" placeholder="Ej: 50000" value="<?= htmlspecialchars($_GET['precio_max'] ?? '') ?>">
            </div>
            <div>
                <button type="submit" class="btn-filtrar">Filtrar Productos</button>
            </div>
        </form>
    </div>

    <!-- Lista de Productos -->
    <div class="grid-productos">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $prod): ?>
                <div class="card-producto">
                    <div>
                        <img src="/proyecto_tejas/public/uploads/<?= htmlspecialchars($prod['imagen']) ?>" class="card-img" alt="Teja" onerror="this.src='https://via.placeholder.com/300x180?text=Teja'">
                        <div class="card-body">
                            <span class="card-badge"><?= htmlspecialchars($prod['categoria_nombre'] ?? 'Teja') ?></span>
                            <h3 class="card-title"><?= htmlspecialchars($prod['nombre']) ?></h3>
                            <div class="card-price">$<?= number_format($prod['precio'], 2) ?></div>
                            <div class="card-info"><strong>Material:</strong> <?= htmlspecialchars($prod['material']) ?></div>
                            <div class="card-info"><strong>Stock:</strong> <?= $prod['stock'] ?> unidades</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/proyecto_tejas/public/catalogo/detalle/<?= $prod['id'] ?>" class="btn-detalle">Ver Ficha Técnica / Detalle</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1 / -1; text-align: center; color: #777; padding: 40px;">No se encontraron productos disponibles con los criterios seleccionados.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>