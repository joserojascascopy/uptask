<div class="container olvide">

    <h1 class="text-center uptask">Uptask</h1>
    <p class="text-center tagline">Crea y Administra tus proyectos</p>

    <div class="container-sm">
        <p class="descripcion-pagina text-center">Recupera tu acceso a Uptask</p>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <form class="formulario" method="POST" action="/olvide" novalidate>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Tu email">
            </div>

            <div class="btn-olvide">
                <input type="submit" value="Enviar Instrucciones">
            </div>
        </form>

        <div class="acciones">
            <a href="/crear">¿Aun no tienes una cuenta? Obtener una</a>
            <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
        </div>

    </div>
</div>