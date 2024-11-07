<?php

namespace App\Entity\DTO;

use App\Contracts\Entity\LanguageInterface;
use App\Entity\Trait\Language\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,ReferenceTrait};

class LanguageDTO extends AbstractEntityDTO implements LanguageInterface {

  use IdentifierTrait;
  use ReferenceTrait;
  use SerializerTrait;

  protected function __construct(
    private ?string $englishName=null,
    ?string $code=null,
    ?string $name=null,
  ) {
    $this->setCode($code);
    $this->setName($name);
  }

  public function getEnglishName(): ?string { return $this->englishName; }
}
