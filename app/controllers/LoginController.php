<?php

namespace Controllers;

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
        $alertas = $usuario::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            // Validación para el formulario de crear una nueva cuenta
            $alertas = $usuario->createAccountValidation();
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario
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