<?php
// Cargar encabezado si existe
if (file_exists(__DIR__ . '/../../layouts/header.php')) {
    include_once __DIR__ . '/../../layouts/header.php';
}
?>

<!-- Carga de Bootstrap y FontAwesome por CDN si no vienen cargados en el proyecto -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .prov-container {
        max-width: 1300px;
        margin: 30px auto;
        padding: 0 20px;
    }
    .card-custom {
        background: #ffffff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        margin-bottom: 30px;
        overflow: hidden;
    }
    .card-header-primary {
        background-color: #2c3e50;
        color: #ffffff;
        padding: 16px 24px;
    }
    .card-header-dark {
        background-color: #34495e;
        color: #ffffff;
        padding: 16px 24px;
    }
    .form-label {
        font-weight: 600;
        color: #34495e;
        font-size: 0.9rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #ced4da;
    }
    .form-control:focus, .form-select:focus {
        border-color: #27ae60;
        box-shadow: 0 0 0 0.25rem rgba(39, 174, 96, 0.25);
    }
    .btn-submit-prov {
        background-color: #27ae60;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        transition: background 0.2s;
    }
    .btn-submit-prov:hover {
        background-color: #219150;
        color: white;
    }
    .table-responsive {
        border-radius: 0 0 12px 12px;
    }
    .table-custom {
        margin-bottom: 0;
    }
    .table-custom thead {
        background-color: #2c3e50;
        color: white;
    }
    .table-custom th {
        font-weight: 600;
        padding: 14px 16px;
        border: none;
    }
    .table-custom td {
        padding: 14px 16px;
        vertical-align: middle;
    }
    .badge-activo {
        background-color: #d4edda;
        color: #155724;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-inactivo {
        background-color: #e2e3e5;
        color: #383d41;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>

<div class="prov-container">
    
    <!-- ENCABEZADO DE PÁGINA -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-truck-field me-2 text-success"></i>Gestión de Proveedores
            </h2>
            <p class="text-muted mb-0">Administra la información de proveedores y suministros</p>
        </div>
        <a href="/proyecto_tejas/public/home/index" class="btn btn-outline-secondary px-3 py-2 fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- FORMULARIO DE REGISTRO / EDICIÓN -->
    <div class="card-custom">
        <div class="card-header-primary d-flex align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fa-solid <?= isset($proveedor_editar) && $proveedor_editar ? 'fa-pen-to-square' : 'fa-plus-circle' ?> me-2"></i>
                <?= isset($proveedor_editar) && $proveedor_editar ? 'Editar Proveedor #' . htmlspecialchars($proveedor_editar['id']) : 'Registrar Nuevo Proveedor' ?>
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="/proyecto_tejas/public/proveedor/guardar" method="POST">
                <?php if (isset($proveedor_editar) && $proveedor_editar): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($proveedor_editar['id']) ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">NIT / Documento *</label>
                        <input type="text" name="nit" class="form-control" placeholder="Ej: 900123456-1" value="<?= htmlspecialchars($proveedor_editar['nit'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Razón Social / Nombre *</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Tejas y Cubiertas S.A.S." value="<?= htmlspecialchars($proveedor_editar['nombre'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Persona de Contacto</label>
                        <input type="text" name="contacto" class="form-control" placeholder="Ej: Juan Pérez" value="<?= htmlspecialchars($proveedor_editar['contacto'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" placeholder="Ej: 3001234567" value="<?= htmlspecialchars($proveedor_editar['telefono'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" placeholder="contacto@proveedor.com" value="<?= htmlspecialchars($proveedor_editar['email'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="activo" <?= (isset($proveedor_editar['estado']) && $proveedor_editar['estado'] === 'activo') ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= (isset($proveedor_editar['estado']) && $proveedor_editar['estado'] === 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dirección / Ciudad</label>
                        <input type="text" name="direccion" class="form-control" placeholder="Ej: Calle 10 # 15-20" value="<?= htmlspecialchars($proveedor_editar['direccion'] ?? '') ?>">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <?php if (isset($proveedor_editar) && $proveedor_editar): ?>
                        <a href="/proyecto_tejas/public/proveedor/index" class="btn btn-light me-2 fw-semibold">Cancelar</a>
                    <?php endif; ?>
                    <button type="submit" class="btn-submit-prov">
                        <i class="fa-solid fa-floppy-disk me-1"></i> <?= isset($proveedor_editar) && $proveedor_editar ? 'Guardar Cambios' : 'Registrar Proveedor' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLA DE PROVEEDORES REGISTRADOS -->
    <div class="card-custom">
        <div class="card-header-dark d-flex align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2"></i>Listado de Proveedores</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-custom align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIT</th>
                        <th>Razón Social</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($proveedores)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                                No hay proveedores registrados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($proveedores as $prov): ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?= $prov['id'] ?></td>
                                <td><strong><?= htmlspecialchars($prov['nit']) ?></strong></td>
                                <td><?= htmlspecialchars($prov['nombre']) ?></td>
                                <td><?= htmlspecialchars($prov['contacto'] ?: '—') ?></td>
                                <td><?= htmlspecialchars($prov['telefono'] ?: '—') ?></td>
                                <td><?= htmlspecialchars($prov['email'] ?: '—') ?></td>
                                <td>
                                    <span class="<?= ($prov['estado'] ?? 'activo') === 'activo' ? 'badge-activo' : 'badge-inactivo' ?>">
                                        <?= ucfirst(htmlspecialchars($prov['estado'] ?? 'activo')) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="/proyecto_tejas/public/proveedor/index/<?= $prov['id'] ?>" class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="/proyecto_tejas/public/proveedor/eliminar/<?= $prov['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?');" title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
// Cargar pie de página si existe
if (file_exists(__DIR__ . '/../../layouts/footer.php')) {
    include_once __DIR__ . '/../../layouts/footer.php';
}
?>