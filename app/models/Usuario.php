<?php

namespace Models;

class Usuario extends Model {
    // Atributos de la DB
    protected static $columnDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];
    protected static $table = 'usuarios';

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
    }

    // Validación de "Crear una nueva cuenta"
    public function createAccountValidation() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre no puede estar vacio';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }else {
            // Validación por cantidad de carácteres
            if(strlen($this->password) < 6) {
                self::$alertas['error'][] = 'La contraseña debe contener al menos 6 carácteres';
            }

            // Validación de que ambas contraseñas sean iguales
            if($this->password !== $this->password2) {
                self::$alertas['error'][] = 'Las contraseñas no coinciden';
            }
        }

        return self::$alertas;
    }
}