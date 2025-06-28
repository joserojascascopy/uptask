<?php

namespace Controllers;

use MVC\Router;

class DashboardController {
    public static function proyectos(Router $router) {
        isAuth();

        $router->render('dashboard/proyectos', [
            'titulo' => 'Proyectos',
            'nombre' => $_SESSION['nombre']
        ]);
    }
    
    public static function crear(Router $router) {
        isAuth();

        $router->render('dashboard/crear', [
            'titulo' => 'Crear Proyecto',
            'nombre' => $_SESSION['nombre']
        ]);
    }

    public static function perfil(Router $router) {
        isAuth();

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'nombre' => $_SESSION['nombre']
        ]);
    }
}