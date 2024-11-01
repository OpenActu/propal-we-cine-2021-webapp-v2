<?php

namespace App\Entity;

use App\Entity\Trait\Language\ReceiverDTOTrait;
use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Contracts\{EntityInterface, ReceiverDTOInterface};

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language implements ReceiverDTOInterface, EntityInterface
{
    use ReceiverDTOTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $englishName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getEnglishName(): ?string
    {
        return $this->englishName;
    }

    public function setEnglishName(?string $englishName): static
    {
        $this->englishName = $englishName;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
