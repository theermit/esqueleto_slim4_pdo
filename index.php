<?php

use \Handlers\HttpErrorHandler;
use \Handlers\ShutdownHandler;
use \Slim\Factory\AppFactory;
use \Slim\Factory\ServerRequestCreatorFactory;
use \DI\ContainerBuilder;
use \Services\PHPDI;
use \Routes\Routes;
use \Routes\CORS;


require 'vendor/autoload.php';

$propriedadesPessoa = array('nome', 'telefone', 'email');

$containerBuilder = new ContainerBuilder();

PHPDI::SetDefinitions($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);

$displayErrorDetails = true;

$app = AppFactory::create();

$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Configuração do CORS
CORS::SetCORS($app);

$errorMidleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMidleware->setDefaultErrorHandler($errorHandler);

Routes::SetRoutes($app);

$app->run();