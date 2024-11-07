<?php

namespace App\Entity\DTO;

use App\Utils\DesignPattern\Singleton\SingletonTrait;
use App\Contracts\{EntityInterface, EntityDTOInterface, SerializerInterface};
use App\Contracts\DesignPattern\SingletonInterface;

abstract class AbstractEntityDTO implements EntityInterface, EntityDTOInterface, SerializerInterface, SingletonInterface {
    use SingletonTrait;
}
