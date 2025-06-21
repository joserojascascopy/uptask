<?php

namespace Controllers;

use Classes\Email;
use Models\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Render de la vista Login
        $router->render('auth/login', [
            'titulo' => 'Login'
        ]);
    }

    public static function logout() {
        echo "Desde logout";
    }

    public static function crear(Router $router) {
        // Instanciamos el objeto de "Usuario"
        $usuario = new Usuario;
        // Array de alertas vacio
        $alertas = Usuario::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            // Validación para el formulario de crear una nueva cuenta
            $alertas = $usuario->createAccountValidation();

            if(empty($alertas)) {
                // Revisar si ya existe el usuario
                $usuarioRegistrado = Usuario::where('email', $usuario->email);

                if($usuarioRegistrado) {
                    $alertas = Usuario::setAlerta('error', 'El usuario ya esta registrado');
                }else {
                    // Hashear el password
                    $usuario->hashPassword();
                    // Eliminar password2
                    unset($usuario->password2);
                    // Generar el token unico
                    $usuario->tokenGenerate();
                    // Crear el nuevo usuario
                    $resultado = $usuario->crear();
                    // Enviar el correo con las instrucciones para confirmar la cuenta
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $sendEmail = $email->enviarConfirmacion();

                    if($resultado && $sendEmail) {
                        header('Location: /mensaje');
                    }else {
                        $alertas = Usuario::setAlerta('error', 'Hubo un error al crear la cuenta');
                    }
                }
            }
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router) {
        // Instanciamos el objeto de usuario vacio para evitar error y poder usar los metodos no estaticos
        $usuario = new Usuario;
        // Array de alertas vacio
        $alertas = Usuario::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            // Validar el formulario
            $alertas = $usuario->emailValidation();
            
            if(empty($alertas)) {
                $email = $usuario->email;
                /** @var Usuario|null $usuario */
                $usuario = Usuario::where('email', $email);

                if($usuario && $usuario->confirmado) {
                    // Generar el nuevo token unico
                    $usuario->tokenGenerate();
                    // Eliminar password2 del objeto para poder actualizar en la DB
                    unset($usuario->password2);
                    // Enviar el correo y actualizar el usuario con el nuevo token en la DB
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarReestablecer();

                    $resultado = $usuario->guardar();

                    if($resultado && $email) {
                        $alertas = Usuario::setAlerta('exito', 'Se ha enviado un correo a su email con las instrucciones para reestablecer su contraseña');
                    }else {
                        $alertas = Usuario::setAlerta('error', 'Ocurrio un error, intente de nuevo');
                    }
                }else {
                    $alertas = Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvidaste tu contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router) {
        // Instanciar el objeto de usuario para evitar errores y poder utilizar los metodos no estaticos
        $usuario = new Usuario;
        // Obtenemos el array de alertas vacio desde la clase
        $alertas = Usuario::getAlertas();
        $error = false;

        // Accedemos al token del query string
        $token = $_GET['token'];

        // Redirigir si no existe el token
        if(!$token) header('Location: /');

        // Encontrar al usuario por medio del token
        /** @var Usuario|null $usuario */
        $usuario = Usuario::where('token', $token);

        if(!$usuario) {
            $alertas = Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Acceder a la nueva contraseña por el metodo POST
            $newPassword = new Usuario($_POST);
            // Validar el formulario
            $alertas = $newPassword->passwordValidation();

            if(empty($alertas)) {
                // Eliminar password2 del objeto usuario para evitar errores con la DB
                unset($usuario->password2);
                // Eliminar el token
                $usuario->token = '';
                // Asignar la nueva contraseña en el objeto de usuario
                $usuario->password = $newPassword->password;
                // Hashear la nueva contraseña
                $usuario->hashPassword();
                // Actualizar el usuario en la DB
                $resultado = $usuario->guardar();
            
                if($resultado) {
                    $alertas = Usuario::setAlerta('exito', 'Contraseña reestablecida correctamente');
                }else {
                    $alertas = Usuario::setAlerta('exito', 'Ocurrio un error al reestablecer la contraseña');
                }
            }
        }

        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer contraseña',
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function mensaje(Router $router) {
        
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router) {
        $alertas = Usuario::getAlertas();
        $error = false;

        $token = $_GET['token'];

        if(!$token) header('Location: /');

        // Encontrar al usuario por medio del token
        /** @var Usuario|null $usuario */
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // No se encontro un usuario con el token
            $alertas = Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            // Eliminar el token
            $usuario->token = '';
            // Eliminar el "password2" del objeto para poder guardar en la DB
            unset($usuario->password2);
            // Actualizamos el usuario
            $resultado = $usuario->guardar();

            if($resultado) {
                $alertas = Usuario::setAlerta('exito', 'Su cuenta ha sido confirmada con exito');
            }
        }

        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar Cuenta',
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
}