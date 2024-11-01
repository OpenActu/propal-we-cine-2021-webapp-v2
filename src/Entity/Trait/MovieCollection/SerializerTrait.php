<?php 
namespace App\Entity\Trait\MovieCollection;

trait SerializerTrait {
    public function serializeToArray(): array {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}