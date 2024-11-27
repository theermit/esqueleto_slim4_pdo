<?php 
namespace Services;

use PDO;
class DbConn extends BaseObject
{
    function GetConn():PDO
    {
        $config = $this->container->get("GetConfig");
        $conn = new PDO($config["db"]["dsn"], $config["db"]["username"], $config["db"]['password'], $config["db"]['options']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}