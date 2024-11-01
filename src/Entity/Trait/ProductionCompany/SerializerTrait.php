<?php 
namespace App\Entity\Trait\ProductionCompany;

trait SerializerTrait {
  public function serializeToArray(): array {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
    ];
  }
}