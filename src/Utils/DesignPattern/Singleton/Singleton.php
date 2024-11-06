<?php 
namespace App\Utils\DesignPattern\Singleton;

use App\Contracts\EntityInterface;
use App\Contracts\DesignPattern\SingletonInterface;

abstract class Singleton implements SingletonInterface {
    public static function getInstance(...$args): EntityInterface { 
        $classname = get_called_class();
        return new $classname(...$args);
    }
}