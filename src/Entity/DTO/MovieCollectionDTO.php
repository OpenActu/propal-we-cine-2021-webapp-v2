<?php

namespace App\Entity\DTO;

use App\Entity\Trait\MovieCollection\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};

class MovieCollectionDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use PathTrait;
  use SerializerTrait;

  public function __construct(
    int $id,
    string $name,
    ?string $backdropPath=null,
    ?string $posterPath=null,
  ){
    $this->setName($name);
    $this->setId($id);
    if($backdropPath)
      $this->setBackdrop(new ImageDTO($backdropPath));
    if($posterPath)
      $this->setPoster(new ImageDTO($posterPath));
  }
}
