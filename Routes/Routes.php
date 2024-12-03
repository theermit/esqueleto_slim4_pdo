<?php 
namespace Routes;
use \Slim\App;
use Controllers\PessoaController;

class Routes
{
    public static function SetRoutes(App $app)
    {
        $app->get("/pessoa", PessoaController::class . ":GetAll");

        $app->get("/pessoa/{id}", PessoaController::class . ":Get");

        $app->post("/pessoa", PessoaController::class . ":Post");

        $app->put("/pessoa/{id}", PessoaController::class . ":Put");

        $app->delete("/pessoa/{id}", PessoaController::class . ":Delete");
    }
}