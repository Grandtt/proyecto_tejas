<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    .detalle-container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: start;
    }
    @media (max-width: 768px) {
        .detalle-container {
            grid-template-columns: 1fr;
        }
    }
    .detalle-img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 6px;
        background: #f9f9f9;
        border: 1px solid #eee;
    }
    .detalle-info h1 {
        color: #2c3e50;
        font-size: 1.8rem;
        margin-top: 0;
        margin-bottom: 10px;
    }
    .detalle-descripcion {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    .detalle-precio {
        font-size: 1.5rem;
        font-weight: bold;
        color: #27ae60;
        margin-bottom: 20px;
    }
    .tabla-especificaciones {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }
    .tabla-especificaciones th, .tabla-especificaciones td {
        padding: 8px 10px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }
    .tabla-especificaciones th {
        color: #2c3e50;
        width: 40%;
    }
    .tabla-especificaciones td {
        color: #555;
    }
    .form-agregar-detalle {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }
    .form-group-cantidad {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .input-cantidad-detalle {
        width: 70px;
        padding: 8px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }
    .btn-agregar-carrito {
        background: #e67e22;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        text-align: center;
        transition: background 0.2s;
    }
    .btn-agregar-carrito:hover {
        background: #d35400;
    }
    .btn-volver {
        display: inline-block;
        margin-bottom: 15px;
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }
    .btn-volver:hover {
        text-decoration: underline;
    }
</style>

<div style="max-width: 1060px; margin: 20px auto; padding: 0 20px;">
    <a href="/proyecto_tejas/public/catalogo/index" class="btn-volver">← Volver al Catálogo</a>

    <div class="detalle-container">
        <!-- Columna de la Imagen -->
        <div>
            <img src="/proyecto_tejas/public/uploads/<?= htmlspecialchars($producto['imagen'] ?? '') ?>" class="detalle-img" alt="Teja" onerror="this.src='https://via.placeholder.com/400x350?text=Teja'">
        </div>

        <!-- Columna de la Información y Formulario -->
        <div class="detalle-info">
            <h1><?= htmlspecialchars($producto['nombre'] ?? 'Producto') ?></h1>
            
            <p class="detalle-descripcion">
                <?= htmlspecialchars($producto['descripcion'] ?? 'Cubierta decorativa liviana e impermeable ideal para techos y proyectos de construcción.') ?>
            </p>

            <div class="detalle-precio">
                $<?= number_format($producto['precio'] ?? 0, 2) ?> <span style="font-size: 0.9rem; color: #7f8c8d; font-weight: normal;">c/u</span>
            </div>

            <h4 style="color: #2c3e50; margin-bottom: 10px; border-bottom: 2px solid #e67e22; padding-bottom: 5px;">Especificaciones Técnicas:</h4>
            
            <table class="tabla-especificaciones">
                <tr>
                    <th>Material:</th>
                    <td><?= htmlspecialchars($producto['material'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Dimensiones:</th>
                    <td><?= htmlspecialchars($producto['dimensiones'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Peso:</th>
                    <td><?= htmlspecialchars($producto['peso'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Rendimiento por m²:</th>
                    <td><?= htmlspecialchars($producto['rendimiento'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Resistencia:</th>
                    <td><?= htmlspecialchars($producto['resistencia'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Stock Disponible:</th>
                    <td><?= htmlspecialchars($producto['stock'] ?? 0) ?> unidades</td>
                </tr>
            </table>

            <!-- Formulario funcional de Añadir al Carrito -->
            <form action="/proyecto_tejas/public/carrito/agregar" method="POST" class="form-agregar-detalle">
                <input type="hidden" name="id_producto" value="<?= $producto['id'] ?>">
                <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">

                <div class="form-group-cantidad">
                    <label for="cantidad" style="font-weight: bold; color: #2c3e50;">Cantidad deseada:</label>
                    <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="<?= $producto['stock'] ?? 99 ?>" class="input-cantidad-detalle">
                </div>

                <button type="submit" class="btn-agregar-carrito">
                    🛒 Añadir al Carrito
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>