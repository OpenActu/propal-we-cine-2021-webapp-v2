<?php 
namespace App\Utils\DesignPattern\Singleton;

use App\Contracts\DesignPattern\SingletonInterface;

abstract class Singleton  {
    public static function getInstance(...$args): SingletonInterface { 
        $classname = get_called_class();
        return new $classname(...$args);
    }
}