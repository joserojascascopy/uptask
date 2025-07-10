<?php

namespace Controllers;

class TareaController {
    public static function index() {

    }

    public static function crear() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json'); // Indica al navegador (o a quien consuma el endpoint) que la respuesta es JSON. O sino el navegador o herramientas pueden mostrarlo como text/html

            

            echo json_encode($_POST);
        }
    }

    public static function actualizar() {
        header('Content-Type: application/json');

        $body = json_decode(file_get_contents('php://input'), true);
    }

    public static function eliminar() {
        header('Content-Type: application/json');

        $body = json_decode(file_get_contents('php://input'), true);
    }
}