<div class="container login">

    <h1 class="text-center uptask">Uptask</h1>
    <p class="text-center tagline">Crea y Administra tus proyectos</p>

    <div class="container-sm">

        <p class="descripcion-pagina text-center">Iniciar Sesión</p>

        <form class="formulario" method="POST" action="/">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Tu email">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Tu contraseña">
            </div>

            <div class="btn-login">
                <input type="submit" value="Iniciar Sesión">
            </div>

        </form>

        <div class="acciones">
            <a href="/crear">¿Aun no tienes una cuenta? Obtener una</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>

    </div>
</div>