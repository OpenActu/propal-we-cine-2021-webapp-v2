<?php 
namespace App\Entity\DTO;

use App\Contracts\DocumentInterface;
use App\Entity\Trait\Image\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,ReferenceTrait};
use Symfony\Component\Serializer\Annotation\Groups;

class ImageDTO extends AbstractEntityDTO implements DocumentInterface {

    use SerializerTrait;

    #[Groups(['global_dto_read'])]
    private string $filename;

    protected function __construct(
        string $filename
    ) { 
        $this->setFilename($filename);
    }
    public function getId(): ?int { return null; }
    public function getName(): ?string { return null; }
    public function getFilename(): string { return $this->filename; }
    public function setFilename(string $filename): static { $this->filename=$filename; return $this; }
    public function getType(): string { return null; }
    public function getSize(): ?string { return null; }
    public function getOriginFilename(): string { return $this->filename; } 
}