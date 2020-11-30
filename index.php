<?php
require __DIR__ . '/vendor/autoload.php';

use Config\Database;
use \Firebase\JWT\JWT;

use Slim\Factory\AppFactory;

use Slim\Routing\RouteCollectorProxy;

use App\Controllers\SocioController;
use App\Controllers\EmpleadoController;
use App\Controllers\ClienteController;
use App\Controllers\PedidoController;

use App\Middlewares\JsonMiddleware;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\ClienteMiddleware;

/*
session_start();
// $container = new Container();
// AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
*/

$app = AppFactory::create();
$app->setBasePath("/progIII/TPComanda - HNG");
$app->addRoutingMiddleware();

new Database;

$app->group('', function (RouteCollectorProxy $group) {

    /**
    * GROUPO PARA REGISTRO GRAL
    */
    $group->group('/registro', function (RouteCollectorProxy $groupRegis) {
        $groupRegis->post('/altaSocio', SocioController::class.":registro");
        $groupRegis->post('/altaEmpleado', EmpleadoController::class.":registro");
        $groupRegis->post('/altaCliente', ClienteController::class.":registro");
        $groupRegis->post('/altaMesa', PedidoController::class.":altaMesa")->add(new AdminMiddleware);
    });
    
    /**
    * GROUPO PARA RELACIONADO A PEDIDOS
    */
    $group->group('/pedido', function (RouteCollectorProxy $groupPed) {
        $groupPed->post('/altaPedido', PedidoController::class.":alta")->add(new ClienteMiddleware);
        $groupPed->post('/prepararPedido', PedidoController::class.":prepararPedido");
        $groupPed->post('/servirPedido', PedidoController::class.":servirPedido");
        $groupPed->get('/codigoMesa/{codigoMesa}/codigoPedido/{codigoPedido}', PedidoController::class . ":getPedido")->add(new ClienteMiddleware);
        $groupPed->get('/pedidosSocio', PedidoController::class.":allPedidoSocio")->add(new AdminMiddleware);
    });

    /**
    * GROUPO RELACIONADO A LAS MESAS
    */
    $group->group('/mesa', function (RouteCollectorProxy $groupMesa) {
        $groupMesa->post('/cobrarMesa', PedidoController::class.":cobrarMesa");    
        $groupMesa->post('/cerrarMesa', PedidoController::class.":cerrarMesa");
    })->add(new AdminMiddleware);

    /**
    * GROUPO RELACIONADO A LAS MESAS
    */
    $group->group('/mesa', function (RouteCollectorProxy $groupEmp) {
        $groupEmp->get('/getEmpleados', SocioController::class . ":getEmpleados")->add(new AdminMiddleware);
    });
});

$app->add(new JsonMiddleware);


$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->run();
?>