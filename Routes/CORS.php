<?php 
namespace Routes;
use \Slim\App;
use \Middlewares\CORS as MidCORS;

class CORS
{
    public static function SetCORS(App $app)
    {
        $c = $app->getContainer();

        $config = $c->get("GetConfig");

        if(!$config["setarCORS"])
            return;

        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });

        $app->add($c->get("CORsMiddleware"));
    }
}