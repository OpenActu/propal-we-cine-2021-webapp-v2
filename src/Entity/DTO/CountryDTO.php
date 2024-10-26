<?php

namespace App\Entity\DTO;

use App\Entity\DTO\Trait\ReferenceTrait;

class CountryDTO {

  use ReferenceTrait;

  public function __construct(
    ?string $code=null,
    ?string $name=null
  ) {
    $this->setCode($code);
    $this->setName($name);
  }
  public function getISO_3166_1(): ?string { return $this->getCode(); }
}
