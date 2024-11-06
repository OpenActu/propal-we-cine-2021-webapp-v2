<?php

namespace App\Entity\DTO;

use App\Utils\DesignPattern\Singleton\Singleton;
use App\Contracts\{EntityInterface, EntityDTOInterface, SerializerInterface};
use App\Contracts\DesignPattern\SingletonInterface;

abstract class AbstractEntityDTO extends Singleton implements EntityInterface, EntityDTOInterface, SerializerInterface, SingletonInterface {

}
