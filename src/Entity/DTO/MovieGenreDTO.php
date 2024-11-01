<?php

namespace App\Entity\DTO;

use App\Contracts\Entity\MovieGenreInterface;
use App\Entity\Trait\MovieGenre\SerializerTrait;
use App\Entity\DTO\Trait\IdentifierTrait;

class MovieGenreDTO extends AbstractEntityDTO implements MovieGenreInterface {

  use IdentifierTrait;
  use SerializerTrait;

  public function __construct(?int $id=null,?string $name=null) {
    if(!empty($id))
      $this->setId($id);
    if(!empty($name))
      $this->setName($name);
  }
}
