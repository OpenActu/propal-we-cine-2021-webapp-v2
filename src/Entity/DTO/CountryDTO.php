<?php

namespace App\Entity\DTO;

use App\Entity\DTO\Trait\{IdentifierTrait,ReferenceTrait};

class CountryDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use ReferenceTrait;

  public function __construct(
    ?string $code=null,
    ?string $name=null
  ) {
    $this->setCode($code);
    $this->setName($name);
  }
  public function getISO_3166_1(): ?string { return $this->getCode(); }

  public function serializeToArray(): array {
    return [
      'code' => $this->getCode(),
      'name' => $this->getName(),
    ];
  }
}
