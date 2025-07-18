<?php

namespace Controllers;

use Models\Proyecto;
use Models\Tarea;

class TareaController {
    public static function index() {
        header('Content-Type: application/json');
        isAuth();
        $usuario_id = $_SESSION['id'];

        // Obtenemos la url del proyecto del query string
        $url = $_GET['url'];

        if (!$url) header('Location: /dashboard');

        // Buscamos el proyecto con la url
        /** @var Proyecto|null $proyecto */
        $proyecto = Proyecto::where('url', $url);

        if (!$proyecto || $usuario_id !== $proyecto->usuario_id) header('Location: /404');

        $proyecto_id = $proyecto->id;

        $tareas = Tarea::belongsTo('proyecto_id', $proyecto_id);

        http_response_code(200);

        $response = [
            'success' => true,
            'tareas' => $tareas
        ];

        echo json_encode($response);
    }

    public static function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json'); // Indica al navegador (o a quien consuma el endpoint) que la respuesta es JSON. O sino el navegador o herramientas pueden mostrarlo como text/html
            isAuth();
            $usuario_id = $_SESSION['id'];
            // url del proyecto enviado desde el frontend
            $url = $_POST['url'];
            // Verificar que exista el proyecto
            /** @var Proyecto|null $proyecto */
            $proyecto = Proyecto::where('url', $url);

            if (!$proyecto || $usuario_id !== $proyecto->usuario_id) {
                http_response_code(404); // Codigo correcto para "no encontrado"

                $response = [
                    'success' => false,
                    'message' => 'Hubo un error al agregar la tarea'
                ];

                echo json_encode($response);

                return;
            }

            $tarea = new Tarea($_POST);

            $tarea->proyecto_id = $proyecto->id;

            $resultado = $tarea->guardar();

            if ($resultado['resultado']) {
                http_response_code(200);

                $response = [
                    'success' => true,
                    'message' => 'Tarea agregada correctamente',
                    'id' => $resultado['id'],
                    'proyecto_id' => $proyecto->id
                ];

                echo json_encode($response);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Hubo un error al agregar la tarea'
                ];

                echo json_encode($response);
            }
        }
    }

    public static function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            isAuth();
            $usuario_id = $_SESSION['id'];
            // url del proyecto enviado desde el frontend
            $url = $_POST['url'];
            // Verificar que exista el proyecto
            /** @var Proyecto|null $proyecto */
            $proyecto = Proyecto::where('url', $url);

            if (!$proyecto || $usuario_id !== $proyecto->usuario_id) {
                http_response_code(404); // Codigo correcto para "no encontrado"

                $response = [
                    'success' => false,
                    'message' => 'Hubo un error al actualizar la tarea'
                ];

                echo json_encode($response);

                return;
            }

            $tarea = new Tarea($_POST);

            $resultado = $tarea->guardar();

            if ($resultado) {
                $response = [
                    'success' => true,
                    'id' => $tarea->id,
                    'nombre' => $tarea->nombre,
                    'proyecto_id' => $proyecto->id,
                    'message' => 'Tarea actualizada correctamente',
                    'estado' => $tarea->estado
                ];

                echo json_encode($response);
            }
        }
    }

    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            isAuth();
            $usuario_id = $_SESSION['id'];
            // url del proyecto enviado desde el frontend
            $url = $_POST['url'];
            // Verificar que exista el proyecto
            /** @var Proyecto|null $proyecto */
            $proyecto = Proyecto::where('url', $url);

            if (!$proyecto || $usuario_id !== $proyecto->usuario_id) {
                http_response_code(404); // Codigo correcto para "no encontrado"

                $response = [
                    'success' => false,
                    'message' => 'Hubo un error al eliminar la tarea'
                ];

                echo json_encode($response);

                return;
            }

            $tarea = new Tarea($_POST);
            
            $resultado = $tarea->eliminar();

            if ($resultado) {
                $response = [
                    'success' => true,
                    'id' => $tarea->id,
                    'message' => 'Tarea eliminada correctamente'
                ];

                echo json_encode($response);
            }
        }
    }
}
