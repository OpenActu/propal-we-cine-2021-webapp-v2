<?php

namespace App\Entity\DTO;

use App\Entity\DTO\Trait\{IdentifierTrait,ReferenceTrait};

class LanguageDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use ReferenceTrait;

  public function __construct(
    private ?string $englishName=null,
    ?string $code=null,
    ?string $name=null,
  ) {
    $this->setCode($code);
    $this->setName($name);
  }

  public function getEnglishName(): ?string { return $this->englishName; }

  public function serializeToArray(): array {
    return [
      'code' => $this->getCode(),
      'name' => $this->getName(),
      'englishName' => $this->getEnglishName(),
    ];
  }
}
