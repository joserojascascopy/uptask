<?php include_once __DIR__ . '/../dashboard/header-dashboard.php'; ?>
    <div class="container-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <form class="formulario" method="POST" action="/crear-proyecto">
            <?php include_once __DIR__ . '/../dashboard/projects-form.php'; ?>
            <div class="btn-crearproyecto">
                <input type="submit" value="Crear Proyecto">
            </div>
        </form>
    </div>
<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php'; ?>