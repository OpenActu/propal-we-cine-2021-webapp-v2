<?php

namespace App\Entity\DTO;

use App\Contracts\Entity\MovieCollectionInterface;
use App\Entity\Trait\MovieCollection\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};

class MovieCollectionDTO extends AbstractEntityDTO implements MovieCollectionInterface {

  use IdentifierTrait;
  use PathTrait;
  use SerializerTrait;

  protected function __construct(
    int $id,
    string $name,
    ?string $backdropPath=null,
    ?string $posterPath=null,
  ){
    $this->setName($name);
    $this->setId($id);
    if($backdropPath)
      $this->setBackdrop(ImageDTO::getInstance(filename: $backdropPath));
    if($posterPath)
      $this->setPoster(ImageDTO::getInstance(filename: $posterPath));
  }
}
