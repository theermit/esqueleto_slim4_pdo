<?php
namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use PDO;

class PessoaController extends BaseController
{
    public function GetAll (Request $request, Response $response, array $args): Response 
    {
        
        $data = array();
        $conn = $this->container->get('GetConn');
        $stmt = $conn->prepare("select * from `enderecos`");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dataJson = json_encode($data, JSON_NUMERIC_CHECK);
        $response->getBody()->write($dataJson);
        return $response 
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        
    }
    public function Get (Request $request, Response $response, array $args): Response 
    {
    
        if(!is_numeric($args['id']))
            throw new HttpBadRequestException($request);
        $data = array();
        $conn = $this->container->get('GetConn');
        $stmt = $conn->prepare("select * from `enderecos` where `id` = :id;");
    
        $stmt->bindParam(":id", $args['id'], PDO::PARAM_INT);
    
        $stmt->execute();
    
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $dataJson = json_encode($data, JSON_NUMERIC_CHECK);
        $response->getBody()->write($dataJson);
        return $response 
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    
    }
    public function Post (Request $request, Response $response, array $args): Response 
    {
        $postData = $request->getParsedBody();
        
        global $propriedadesPessoa;
    
        foreach( $propriedadesPessoa as $prop) 
            if(!array_key_exists($prop, $postData))
                throw new HttpBadRequestException($request);
    
    
        $conn = $this->container->get('GetConn');
        $stmt = $conn->prepare("INSERT INTO `enderecos`(`nome`, `telefone`, `email`) VALUES (:nome, :telefone, :email)");
    
        $stmt->bindParam(":nome", $postData['nome'], PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $postData['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $postData['email'], PDO::PARAM_STR);
    
        $stmt->execute();
    
        $postData['id'] = $conn->lastInsertId();
    
        $dataJson = json_encode($postData, JSON_NUMERIC_CHECK);
        $response->getBody()->write($dataJson);
        return $response 
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    }
    public function Put (Request $request, Response $response, array $args): Response 
    {
        if(!is_numeric($args['id']))
            throw new HttpBadRequestException($request);
    
        $postData = $request->getParsedBody();
        
        global $propriedadesPessoa;
    
        foreach( $propriedadesPessoa as $prop) 
            if(!array_key_exists($prop, $postData))
                throw new HttpBadRequestException($request);
    
    
        $conn = $this->container->get('GetConn');
        $stmt = $conn->prepare("UPDATE `enderecos` SET `nome` = :nome, `telefone` = :telefone, `email` = :email where `id` = :id");
    
        $stmt->bindParam(":nome", $postData['nome'], PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $postData['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $postData['email'], PDO::PARAM_STR);
        $stmt->bindParam(":id", $args['id'], PDO::PARAM_INT);
    
        $stmt->execute();
    
        if($stmt->rowCount() == 0)
            throw new HttpBadRequestException($request);
    
        return $response 
                ->withStatus(200);
    }
    public function Delete (Request $request, Response $response, array $args): Response 
    {
    
        if(!is_numeric($args['id']))
            throw new HttpBadRequestException($request);
    
        $conn = $this->container->get('GetConn');
    
        $stmt = $conn->prepare("delete from `enderecos` where `id` = :id;");
    
        $stmt->bindParam(":id", $args['id'], PDO::PARAM_INT);
    
        $stmt->execute();
    
        if($stmt->rowCount() == 0)
            return $response->withStatus(404);
    
        return $response->withStatus(204);
    }
}

