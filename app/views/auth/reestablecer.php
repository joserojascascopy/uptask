<div class="container reestablecer">

    <h1 class="text-center uptask">Uptask</h1>
    <p class="text-center tagline">Crea y Administra tus proyectos</p>

    <div class="container-sm">

        <p class="descripcion-pagina text-center">Introduzca su nueva contraseña</p>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    
        <?php if($error) { ?>
    
        <form class="formulario" method="POST">
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Tu contraseña">
            </div>

            <div class="btn-reestablecer">
                <input type="submit" value="Reestablecer Contraseña">
            </div>

        </form>

        <?php } ?>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>

    </div>
</div>