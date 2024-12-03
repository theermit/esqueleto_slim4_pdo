<?php
namespace Services;

use \DI\ContainerBuilder;
use \DI\Container;
use \Config\Config;
use Controllers\PessoaController;
use Services\DbConn;
use Slim\Psr7\Factory\ResponseFactory;
use Middlewares\CORS;

class PHPDI 
{
    public static function SetDefinitions(ContainerBuilder $containerBuilder):void
    {
        $containerBuilder->addDefinitions([
            // Mapeia a interface para a implementação padrão
            "GetConfig" => function ():array{
                return Config::GetConfig();
            },
            ResponseFactory::class => function(){
                return new ResponseFactory;
            },
            DbConn::class =>function(Container $c){
                return new DbConn($c);
            },
            "GetConn" => function(Container $c){
                return $c->get(DbConn::class)->GetConn();
            },
            "CORsMiddleware" => \DI\autowire(CORS::class),
            PessoaController::class => function(Container $c){
                return new PessoaController($c);
            },
        ]);
    } 
}


