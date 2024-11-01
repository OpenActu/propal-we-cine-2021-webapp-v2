<?php 
namespace App\Entity\Trait\MovieGenre;

trait SerializerTrait {
    public function serializeToArray(): array {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}