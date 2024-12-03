<?php 
namespace Config;

#TODO: incluir em config as definicoes de dominio de pessoa
class Config 
{
    public static function GetConfig() : array
    {
        $db = [
            "dsn" => 'sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .  'Data' . DIRECTORY_SEPARATOR . 'DataBase.db',
            "username" => null,
            "password" => null,
            "options" => null
        ];
        $setarCORS = true;

        $CORSDomain = "*";

        return [
            "db" => $db
            ,"setarCORS" => $setarCORS
            ,"CORSDomain" => $CORSDomain
        ];
    }
}