<?php

namespace Controllers;
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

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta'
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