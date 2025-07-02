<?php

namespace Models;
use Models\Model;

class Proyecto extends Model {
    // Atributos de la DB
    protected static $table = 'proyectos';
    protected static $columnDB = ['id', 'proyecto', 'url', 'usuario_id'];

    public $id;
    public $proyecto;
    public $url;
    public $usuario_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? '';
    }

    public function projectValidate() {
        if(!$this->proyecto) {
            self::$alertas['error'][] = 'El nombre del proyecto es obligatorio';
        }

        return self::$alertas;
    }

    public function urlGenerate() {
        $hash = md5(uniqid());
        $this->url = $hash;
    }
}