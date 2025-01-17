<?php

namespace App\Entity;

use App\Contracts\Entity\CountryInterface;
use App\Entity\Trait\Country\ReceiverDTOTrait;
use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Contracts\{EntityInterface, ReceiverDTOInterface};

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country implements ReceiverDTOInterface, EntityInterface, CountryInterface
{
    use ReceiverDTOTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255,nullable: true)]
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
