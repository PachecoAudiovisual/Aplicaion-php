<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginControllers;
use Controllers\ServicioControllers;
use MVC\Router;

$router = new Router();

// iniciar secion
$router->get('/', [LoginControllers::class, 'login']);
$router->post('/', [LoginControllers::class, 'login']);
$router->get('/logout', [LoginControllers::class, 'logout']);

//RECUPERAR PASSWORD

$router->get('/olvide', [LoginControllers::class, 'olvide']);
$router->post('/olvide', [LoginControllers::class, 'olvide']);
$router->get('/recuperar', [LoginControllers::class, 'recuperar']);
$router->post('/recuperar', [LoginControllers::class, 'recuperar']);

// CREAR CUENTAS

$router->get('/crear-cuenta', [LoginControllers::class, 'crear']);
$router->post('/crear-cuenta', [LoginControllers::class, 'crear']);

//CONFIRMAR MAIL
$router->get('/confirmar-cuenta', [LoginControllers::class, 'confirmar']);

$router->get('/mensaje', [LoginControllers::class, 'mensaje']);

//area privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin',[AdminController::class, 'index']);


// API CItas

$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);


///CRUD servicios
$router->get('/servicios', [ServicioControllers::class, 'index']);
$router->get('/servicios/crear', [ServicioControllers::class, 'crear']);
$router->post('/servicios/crear',[ServicioControllers::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioControllers::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioControllers::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioControllers::class, 'eliminar']);




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();