<?php

namespace App\Entity\DTO;

use App\Contracts\Entity\CountryInterface;
use App\Entity\Trait\Country\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,ReferenceTrait};

class CountryDTO extends AbstractEntityDTO implements CountryInterface {

  use IdentifierTrait;
  use ReferenceTrait;
  use SerializerTrait;

  protected function __construct(
    ?string $code=null,
    ?string $name=null
  ) {
    $this->setCode($code);
    $this->setName($name);
  }
  public function getISO_3166_1(): ?string { return $this->getCode(); }
}
