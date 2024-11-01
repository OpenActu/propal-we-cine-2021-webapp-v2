<?php 
namespace App\Entity\Trait\Country;

trait SerializerTrait {
  public function serializeToArray(): array {
    return [
      'code' => $this->getCode(),
      'name' => $this->getName(),
    ];
  }
}