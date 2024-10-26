<?php

namespace App\Entity\DTO;

use App\Contracts\EntityDTOInterface;
use App\Entity\DTO\Trait\IdentifierTrait;

class MovieGenreDTO implements EntityDTOInterface {

  use IdentifierTrait;

  public function __construct(?int $id=null,?string $name=null) {
    if(!empty($id))
      $this->setId($id);
    if(!empty($name))
      $this->setName($name);
  }
}
