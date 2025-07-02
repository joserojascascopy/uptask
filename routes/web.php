<?php

use Controllers\DashboardController;
use Controllers\LoginController;
use MVC\Router;

$router = new Router;

// Login

$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

// Logout

$router->get('/logout', [LoginController::class, 'logout']);

// Crear cuenta

$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

// Olvide mi contraseña

$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);

// Reestablecer contraseña

$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

// Confirmar cuenta

$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);

// Dashboard

$router->get('/dashboard', [DashboardController::class, 'index']);

// Crear Proyecto

$router->get('/crear-proyecto', [DashboardController::class, 'crear']);
$router->post('/crear-proyecto', [DashboardController::class, 'crear']);

// Proyecto

$router->get('/proyecto', [DashboardController::class, 'proyecto']);
$router->post('/proyecto', [DashboardController::class, 'proyecto']);

// Perfil

$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);