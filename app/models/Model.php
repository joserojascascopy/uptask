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

    // Crea un array con llave (las columnas de la DB) y valor (valores del objeto instanciado)
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
        $sanitizado = $this->sanitizarAtributos();

        $query = "INSERT INTO " . static::$table . "(";
        $query .= join(', ', array_keys($sanitizado));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($sanitizado));
        $query .= "')";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    // Realiza una búsqueda en la DB usando una columna y un valor específico
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE {$column} = '{$value}'";

        $resultado = self::consultaSQL($query);

        return array_shift($resultado);
    }

    public static function consultaSQL($query) {
        // Consulta a la DB
        $consulta = self::$db->query($query);

        $array = [];

        while($registro = $consulta->fetch_assoc()) { // Devuelve cada fila como un array asociativo
            $array[] = static::createObject($registro); // Transformamos a objeto los registros
        }

        // Liberar memoria
        $consulta->free();

        // Retornar los resultados (Array de Objetos)
        return $array;
    }

    public static function createObject($registro) {
        $object = new static; // Crea un objeto en la clase donde se esta heredando con los atributos de dicha clase

        foreach($registro as $key => $value) {
            if(property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }
}