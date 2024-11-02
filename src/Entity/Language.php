<?php

namespace App\Entity;

use App\Contracts\Entity\LanguageInterface;
use App\Entity\Trait\Language\ReceiverDTOTrait;
use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Contracts\{EntityInterface, ReceiverDTOInterface};
use App\Entity\Trait\Language\{SerializerTrait};
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language implements ReceiverDTOInterface, EntityInterface, LanguageInterface
{
    use ReceiverDTOTrait;
    use SerializerTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    private ?string $englishName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $locale = null;

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

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }
}
