<?php

namespace App\Entity;

use App\Entity\Trait\MovieGenre\ReceiverDTOTrait;
use App\Repository\MovieGenreRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Contracts\{EntityInterface, ReceiverDTOInterface};

#[ORM\Entity(repositoryClass: MovieGenreRepository::class)]
class MovieGenre implements ReceiverDTOInterface, EntityInterface
{
    use ReceiverDTOTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $tmdbId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(int $tmdbId): static
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }
}
