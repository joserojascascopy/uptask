<?php

namespace Models;

class Tarea extends Model {
    protected static $table = 'tareas';
    protected static $columnDB = ['id', 'nombre', 'estado', 'proyecto_id'];

    public $id;
    public $nombre;
    public $estado;
    public $proyecto_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? 0;
        $this->proyecto_id = $args['proyecto_id'] ?? '';
    }
}