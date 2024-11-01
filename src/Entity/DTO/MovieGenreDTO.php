<?php

namespace App\Entity\DTO;

use App\Entity\Trait\MovieGenre\SerializerTrait;
use App\Entity\DTO\Trait\IdentifierTrait;

class MovieGenreDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use SerializerTrait;

  public function __construct(?int $id=null,?string $name=null) {
    if(!empty($id))
      $this->setId($id);
    if(!empty($name))
      $this->setName($name);
  }
}
