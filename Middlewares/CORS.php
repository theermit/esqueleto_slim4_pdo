<?php 
namespace Middlewares;

use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use \Psr\Http\Message\ResponseInterface as Response;
use Controllers\BaseController;
use Psr\Http\Server\MiddlewareInterface;

class CORS extends BaseController implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler):Response
    {
        $config = $this->container->get("GetConfig");
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', $config["CORSDomain"]) // Substitua pelo domínio desejado
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        
    }
}