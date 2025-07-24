<?php include_once __DIR__ . '/../dashboard/header-dashboard.php'; ?>

<div class="container-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/perfil">
        <div class="form-group">
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" value="<?php echo $nombre; ?>" name="nombre" placeholder="Tú nombre">
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="email" id="email" value="<?php echo $email; ?>" name="email" placeholder="Tú email">
        </div>

        <div class="btn-perfil">
            <input type="submit" value="Guardar Cambios">
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php'; ?>