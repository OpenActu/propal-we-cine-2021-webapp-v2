<?php

namespace App\Entity\DTO;

use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};

class MovieCollectionDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use PathTrait;

  public function __construct(
    int $id,
    string $name,
    ?string $backdropPath=null,
    ?string $posterPath=null,
  ){
    $this->setName($name);
    $this->setId($id);
    $this->setBackdropPath($backdropPath);
    $this->setPosterPath($posterPath);
  }

  public function serializeToArray(): array {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
    ];
  }
}
