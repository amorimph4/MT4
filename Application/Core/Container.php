<?php


namespace Core;

include_once __DIR__ . '/../Core/DataBase.php';

$pasta = './../App/Models/';
$arquivos = glob("$pasta{*.php}", GLOB_BRACE);
foreach($arquivos as $file){
   include_once $file;
}

class Container
{
    public static function newController($controller)
    {
        $objcontroller = include_once __DIR__ . '/../App/Controllers/'.$controller.'.php';
        return $objcontroller;
    }

    public static function getModel($model)
    {
        $objModel = "App\\Models\\".$model;
        return new $objModel(DataBase::getDataBase()); 
    }
}

?>