<?php

namespace Models;

class Model {
    // Conexión a la base de datos
    protected static $db;

    public static function setConnection($database) {
        self::$db = $database;
    }

    // DB
    protected static $columnDB = [];
    protected static $table = '';

    // Alertas y/o Errores
    protected static $alertas = [];

    public static function setAlerta($tipo, $message) {
        static::$alertas[$tipo] = $message;

        return static::$alertas;
    }

    public static function getAlertas() {
        return static::$alertas;
    }

    // Identificar y unir los atributos de la DB (Hace una copia del objeto)
    public function atributos() {
        $atributos = [];

        foreach(static::$columnDB as $column) {
            if($column === 'id') continue;
            
            $atributos[$column] = $this->$column;
        }

        return $atributos;
    }

    // Sanitizar atributos
    public function sanitizarAtributos() {
        $atributos = $this->atributos();

        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Crear
    public function crear() {
        $atributos = $this->sanitizarAtributos();

        $query = "INSERT INTO " . static::$table . "(";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);

        return $resultado;
    }
}