<?php

namespace App\Entity\DTO;

use App\Contracts\{EntityInterface, EntityDTOInterface, SerializerInterface};

abstract class AbstractEntityDTO implements EntityInterface, EntityDTOInterface, SerializerInterface {

}
