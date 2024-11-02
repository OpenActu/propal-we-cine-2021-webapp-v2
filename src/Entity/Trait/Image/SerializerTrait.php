<?php 
namespace App\Entity\Trait\Image;

trait SerializerTrait {
    public function serializeToArray(): array {
        return [
            'filename' => $this->getFilename(),
            'originFilename' => $this->getOriginFilename(),
            'size' => $this->getSize(),
        ];
    }
}