<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    .hero { 
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80'); 
        background-size: cover; 
        background-position: center; 
        color: white; 
        text-align: center; 
        padding: 80px 20px; 
        border-radius: 8px;
        margin-bottom: 30px;
    }
    .hero h2 { font-size: 2.5rem; margin-bottom: 10px; }
    .hero p { font-size: 1.2rem; max-width: 600px; margin: 0 auto 20px; }
    .btn-primary { background-color: #e67e22; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; }
    .btn-primary:hover { background-color: #d35400; }

    .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; text-align: center; }
    .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .card h3 { color: #2c3e50; margin-top: 0; }
</style>

<section class="hero">
    <h2>Materiales de Alta Calidad para tu Construcción</h2>
    <p>Encuentra tejas de barro, termoacústicas, de policarbonato y fibrocemento con las mejores especificaciones técnicas del mercado.</p>
    <a href="/proyecto_tejas/public/catalogo/index" class="btn-primary">Ver Catálogo de Productos</a>
</section>

<div style="max-width: 1100px; margin: auto;">
    <h2 style="text-align:center; margin-bottom: 30px;">¿Por qué elegirnos?</h2>
    <div class="features">
        <div class="card">
            <h3>Variedad de Materiales</h3>
            <p>Contamos con tejas adaptadas a cualquier condición climática y tipo de estructura.</p>
        </div>
        <div class="card">
            <h3>Cálculo Rendimiento m²</h3>
            <p>Fichas técnicas detalladas con resistencia, rendimiento y peso por unidad.</p>
        </div>
        <div class="card">
            <h3>Envíos a Obra</h3>
            <p>Procesamos tus pedidos y realizamos el seguimiento del envío hasta tu domicilio u obra.</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>