<?php

namespace App\Entity\DTO;

use App\Entity\DTO\Trait\IdentifierTrait;

class MovieGenreDTO extends AbstractEntityDTO {

  use IdentifierTrait;

  public function __construct(?int $id=null,?string $name=null) {
    if(!empty($id))
      $this->setId($id);
    if(!empty($name))
      $this->setName($name);
  }

  public function serializeToArray(): array {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
    ];
  }
}
