<style>
    /* Estilos Generales del Footer */
    .site-footer {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 40px 20px 20px 20px;
        margin-top: 50px;
        font-family: Arial, sans-serif;
    }
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
    }
    .footer-column h3, .footer-column h4 {
        color: #e67e22;
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }
    .footer-column p {
        font-size: 0.88rem;
        line-height: 1.6;
        color: #bdc3c7;
        margin-bottom: 10px;
    }
    .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-column ul li {
        margin-bottom: 8px;
    }
    .footer-column ul li a {
        color: #bdc3c7;
        text-decoration: none;
        font-size: 0.88rem;
        transition: color 0.2s;
    }
    .footer-column ul li a:hover {
        color: #e67e22;
    }

    /* SECCIÓN DE INTEGRANTES DEL EQUIPO */
    .team-section {
        max-width: 1200px;
        margin: 40px auto 20px auto;
        border-top: 1px solid #34495e;
        padding-top: 25px;
        text-align: center;
    }
    .team-section h4 {
        color: #e67e22;
        font-size: 1.2rem;
        margin-bottom: 20px;
    }
    .team-grid {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .team-card {
        background-color: #34495e;
        padding: 15px;
        border-radius: 8px;
        width: 160px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transition: transform 0.2s;
    }
    .team-card:hover {
        transform: translateY(-5px);
    }
    .team-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e67e22;
        margin-bottom: 10px;
        background-color: #2c3e50;
    }
    .team-card h5 {
        margin: 5px 0 2px 0;
        color: #ffffff;
        font-size: 0.95rem;
    }
    .team-card p {
        margin: 0;
        color: #f39c12;
        font-size: 0.78rem;
        font-weight: bold;
    }

    .footer-bottom {
        border-top: 1px solid #34495e;
        margin-top: 20px;
        padding-top: 15px;
        text-align: center;
        font-size: 0.85rem;
        color: #7f8c8d;
    }

    /* MODAL DE TRATAMIENTO DE DATOS */
    .modal-datos {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
    }
    .modal-contenido {
        background-color: #ffffff;
        color: #2c3e50;
        margin: 5% auto;
        padding: 30px;
        border-radius: 8px;
        max-width: 700px;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }
    .modal-contenido h2 {
        color: #2c3e50;
        margin-top: 0;
        border-bottom: 2px solid #e67e22;
        padding-bottom: 10px;
    }
    .modal-contenido h4 {
        color: #e67e22;
        margin-top: 20px;
        margin-bottom: 8px;
    }
    .modal-contenido p, .modal-contenido ul {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #4a5568;
    }
    .modal-contenido ul {
        padding-left: 20px;
    }
    .btn-cerrar-modal {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        float: right;
        font-weight: bold;
    }
    .btn-cerrar-modal:hover {
        background-color: #c0392b;
    }
</style>

<footer class="site-footer">
    <div class="footer-container">
        <!-- QUIÉNES SOMOS -->
        <div class="footer-column">
            <h3>🧱 Quiénes Somos</h3>
            <p>
                <strong>Tejas & Cubiertas</strong> es una empresa dedicada a la comercialización y distribución de cubiertas, tejas cerámicas, metálicas y PVC de alta calidad.
            </p>
        </div>

        <!-- MISIÓN -->
        <div class="footer-column">
            <h4>Nuestra Misión</h4>
            <p>
                Proveer materiales de construcción de excelente resistencia y acabado, garantizando la satisfacción con asesoría técnica personalizada.
            </p>
        </div>

        <!-- ENLACES & LEGAL -->
        <div class="footer-column">
            <h4>Enlaces & Legal</h4>
            <ul>
                <li><a href="/proyecto_tejas/public/catalogo/index">Catálogo de Productos</a></li>
                <li><a href="/proyecto_tejas/public/auth/login">Iniciar Sesión</a></li>
                <li><a href="/proyecto_tejas/public/auth/registro">Crear Cuenta</a></li>
                <li><a href="javascript:void(0)" onclick="abrirModalDatos()">📋 Tratamiento de Datos</a></li>
            </ul>
        </div>

        <!-- CONTACTO -->
        <div class="footer-column">
            <h4>Contacto</h4>
            <p>📍 Dirección: Calle Principal #123, Bogotá</p>
            <p>📞 Teléfono: +57 (601) 555-0199</p>
            <p>✉️ Correo: contacto@tejasycubiertas.com</p>
        </div>
    </div>

<!-- SECCIÓN DE EQUIPO / DESARROLLADORES -->
<div class="team-section">
    <h4>⭐ Desarrolladores del Proyecto</h4>
    <div class="team-grid">

        <!-- Integrante 1: Juan Martinez -->
        <div class="team-card">
            <img src="/proyecto_tejas/public/img/equipo/juan.jpg" 
                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Juan+Martinez&background=e67e22&color=fff';" 
                 alt="Juan Martinez" 
                 class="team-avatar">
            <h5>Juan Martinez</h5>
            <p>Desarrollador Lead</p>
        </div>

        <!-- Integrante 2: Harol Barbosa -->
        <div class="team-card">
            <img src="/proyecto_tejas/public/img/equipo/harol.jpg" 
                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Harol+Barbosa&background=e67e22&color=fff';" 
                 alt="Harol Barbosa" 
                 class="team-avatar">
            <h5>Harol Barbosa</h5>
            <p>Ilustrador</p>
        </div>

        <!-- Integrante 3: Yilber Sanchez -->
        <div class="team-card">
            <img src="/proyecto_tejas/public/img/equipo/yilber.jpg" 
                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Yilber+Sanchez&background=e67e22&color=fff';" 
                 alt="Yilber Sanchez" 
                 class="team-avatar">
            <h5>Yilber Sanchez</h5>
            <p>Apoyo emocional</p>
        </div>

    </div>
</div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Tejas & Cubiertas. Todos los derechos reservados. | <a href="javascript:void(0)" onclick="abrirModalDatos()" style="color: #bdc3c7; text-decoration: underline;">Política de datos</a></p>
        <h7>Esta pagina fue creada con fines de practica Sena</h7>
    </div>

</footer>