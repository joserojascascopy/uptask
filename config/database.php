<?php

use Dotenv\Dotenv;

// function connect(): PDO {

//     if (!isset($_ENV['DB_HOST'])) {
//         $dotenv = Dotenv::createImmutable(dirname(__DIR__));
//         $dotenv->load();
//     }

//     $host = $_ENV['DB_HOST'];
//     $dbname = $_ENV['DB_NAME'];
//     $usuario = $_ENV['DB_USER'];
//     $password = $_ENV['DB_PASS'];

//     $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

//     try {
//         return new \PDO($dsn, $usuario, $password, [
//             \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
//             \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
//         ]);
//     } catch (\PDOException $e) {
//         die("Error de conexión: " . $e->getMessage());
//     }
// }

function connect() {
    if (!isset($_ENV['DB_HOST'])) {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    }

    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $usuario = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    
    $db = new mysqli($host, $usuario, $password, $dbname);

    if (!$db) {
        echo "400 Bad Request. No se ha podido establecer la conexión con la base de datos.";
    }

    return $db;
}
