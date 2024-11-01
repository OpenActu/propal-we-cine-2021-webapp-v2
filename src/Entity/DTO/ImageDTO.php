<?php 
namespace App\Entity\DTO;

use App\Contracts\DocumentInterface;
use App\Entity\Trait\Image\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,ReferenceTrait};

class ImageDTO extends AbstractEntityDTO implements DocumentInterface {

    use SerializerTrait;
    
    public function __construct(
        private string $filename
    ) { }
    public function getId(): ?int { return null; }
    public function getName(): ?string { return null; }
    public function getFilename(): string { return $this->filename; }
    public function getType(): string { return null; }
    public function getSize(): ?string { return null; }
    public function getOriginalFilename(): string { return $this->filename; } 
}