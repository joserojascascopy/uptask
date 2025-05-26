<div class="container crear">

    <h1 class="text-center uptask">Uptask</h1>
    <p class="text-center tagline">Crea y Administra tus proyectos</p>

    <div class="container-sm">

        <p class="descripcion-pagina text-center">Crea tu cuenta en UpTask</p>

        <form class="formulario" method="POST" action="/crear">

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Tu email">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Tu contraseña">
            </div>
            <div class="form-group">
                <label for="password2">Repetir Contraseña:</label>
                <input type="password" id="password2" name="password2" placeholder="Repetir contraseña">
            </div>

            <div class="btn-crear">
                <input type="submit" value="Iniciar Sesión">
            </div>

        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>

    </div>
</div>