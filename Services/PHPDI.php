<?php
namespace Services;

use \DI\ContainerBuilder;
use \Config\Config;
use Controllers\BaseController;
use Services\BaseObject;

class PHPDI 
{
    public static function SetDefinitions(ContainerBuilder $containerBuilder):void
    {
        $containerBuilder->addDefinitions([
            // Mapeia a interface para a implementação padrão
            "GetConfig" => function ():array{
                return Config::GetConfig();
            },
            BaseObject::class => \DI\autowire(BaseObject::class),
            "GetConn" => \DI\Factory(function (DbConn $dbConn):\PDO{
                return $dbConn->GetConn();
            }),
            BaseController::class => \DI\autowire(BaseController::class),
        ]);
    } 
}


