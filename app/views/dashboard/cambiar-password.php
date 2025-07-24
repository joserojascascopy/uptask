<?php include_once __DIR__ . '/../dashboard/header-dashboard.php'; ?>

<div class="container-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver a Perfil</a>

    <form class="formulario" method="POST" action="/cambiar-password">
        <div class="form-group">
            <label for="password_actual">Contraseña acutal: </label>
            <input type="password" id="password_actual" name="password_actual" placeholder="Tú contraseña actual">
        </div>
        <div class="form-group">
            <label for="password_nuevo">Nueva contraseña: </label>
            <input type="password" id="password_nuevo" name="password_nuevo" placeholder="Contraseña nueva">
        </div>

        <div class="btn-password">
            <input type="submit" value="Guardar Cambios">
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php'; ?>