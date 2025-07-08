<?php

namespace Controllers;

use Models\Proyecto;
use MVC\Router;

class DashboardController {
    public static function index(Router $router) {
        isAuth();
        // Array de alertas vacio
        $alertas = Proyecto::getAlertas();

        // Asignar el id del usuario a la variable usuario_id
        $usuario_id = $_SESSION['id'];

        // Buscar todos los proyectos del usuario autenticado
        $proyectos = Proyecto::belongsTo('usuario_id', $usuario_id);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'proyectos' => $proyectos
        ]);
    }

    public static function proyecto(Router $router) {
        isAuth();
        // Asignar el id del usuario a la variable usuario_id
        $usuario_id = $_SESSION['id'];
        // Obtener la url proyecto del query string
        $url = $_GET['url'];

        if(!$url) header('Location: /dashboard');

        // Buscar en la DB el proyecto por medio de la url del proyecto
        /** @var Proyecto|null $proyecto */
        $proyecto = Proyecto::where('url', $url);

        // Asignar el titulo del proyecto a una variable
        $titulo = $proyecto->proyecto;
        
        // Verificar si el usuario autenticado es el que creo el proyecto
        if($proyecto->usuario_id !== $usuario_id) {
            header('Location: /dashboard');
        }

        $alertas = [];

        $router->render('dashboard/proyecto', [
            'titulo' => $titulo,
            'nombre' => $_SESSION['nombre'],
            'usuario_id' => $usuario_id,
            'alertas' => $alertas
        ]);
    }
    
    public static function crear(Router $router) {
        isAuth();
        // Asignar el id del usuario a la variable usuario_id
        $usuario_id = $_SESSION['id'];
        // Instancia del objeto Proyectos vacio
        $proyecto = new Proyecto;
        // Array de alertas vacio
        $alertas = Proyecto::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            // Validación
            $alertas = $proyecto->projectValidate();

            if(empty($alertas)) {
                // Generar una URL unica para el proyecto
                $proyecto->urlGenerate();
                // Asignar el usuario_id al objeto de proyecto
                $proyecto->usuario_id = $usuario_id;
                // Guardar el proyecto en la DB
                $resultado = $proyecto->guardar();

                if($resultado) {
                    // Redireccionar al proyecto
                    header('Location: /proyecto?url=' . $proyecto->url);
                }else {
                    $alertas = Proyecto::setAlerta('error', 'Hubo un error al crear el proyecto');
                }
            }
        }

        $router->render('dashboard/crear', [
            'titulo' => 'Crear Proyecto',
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas
        ]);
    }

    public static function perfil(Router $router) {
        isAuth();

        $alertas = [];

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas
        ]);
    }
}