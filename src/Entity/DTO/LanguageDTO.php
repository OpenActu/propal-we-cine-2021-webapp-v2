<?php

namespace App\Entity\DTO;

use App\Entity\Trait\Language\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,ReferenceTrait};

class LanguageDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use ReferenceTrait;
  use SerializerTrait;

  public function __construct(
    private ?string $englishName=null,
    ?string $code=null,
    ?string $name=null,
  ) {
    $this->setCode($code);
    $this->setName($name);
  }

  public function getEnglishName(): ?string { return $this->englishName; }
}
