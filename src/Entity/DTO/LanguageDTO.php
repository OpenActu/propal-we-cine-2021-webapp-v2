<?php

namespace App\Entity\DTO;

use App\Entity\DTO\Trait\ReferenceTrait;

class LanguageDTO {

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
}
