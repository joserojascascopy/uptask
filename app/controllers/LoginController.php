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

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvidaste tu contraseña'
        ]);
    }

    public static function reestablecer(Router $router) {
        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer contraseña'
        ]);
    }

    public static function mensaje(Router $router) {
        
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router) {
        
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar Cuenta'
        ]);
    }
}