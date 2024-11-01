<?php 
namespace App\Entity\Trait\Language;

trait SerializerTrait {

  public function serializeToArray(): array {
    return [
      'code' => $this->getCode(),
      'name' => $this->getName(),
      'englishName' => $this->getEnglishName(),
    ];
  }
}