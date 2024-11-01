<?php 
namespace App\Entity\Trait\Image;

trait SerializerTrait {
    public function serializeToArray(): array {
        return [
            'filename' => $this->getFilename(),
            'originalFilename' => $this->getOriginalFilename(),
            'size' => $this->getSize(),
        ];
    }
}