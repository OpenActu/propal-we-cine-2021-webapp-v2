<?php

namespace App\Entity;

use App\Entity\DTO\MovieDTO;
use App\Entity\Trait\Movie\ReceiverDTOTrait;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Contracts\{EntityInterface, ReceiverDTOInterface};

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource]
class Movie implements ReceiverDTOInterface, EntityInterface
{
    use ReceiverDTOTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?bool $adult = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $originalTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $overview = null;

    #[ORM\Column(nullable: true)]
    private ?float $popularity = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(nullable: true)]
    private ?float $voteAverage = null;

    #[ORM\Column(nullable: true)]
    private ?int $voteCount = null;

    #[ORM\Column(nullable: true)]
    private ?int $budget = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imdbId = null;

    #[ORM\Column(nullable: true)]
    private ?int $revenue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tagline = null;

    #[ORM\Column(nullable: true)]
    private ?bool $video = null;

    #[ORM\Column(nullable: true)]
    private ?int $tmdbId = null;

    #[ORM\ManyToOne]
    private ?Language $originalLanguage = null;

    /**
     * @var Collection<int, MovieGenre>
     */
    #[ORM\ManyToMany(targetEntity: MovieGenre::class)]
    private Collection $genres;

    /**
     * @var Collection<int, Country>
     */
    #[ORM\ManyToMany(targetEntity: Country::class)]
    private Collection $originCountries;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->originCountries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isAdult(): ?bool
    {
        return $this->adult;
    }

    public function setAdult(?bool $adult): static
    {
        $this->adult = $adult;

        return $this;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(?string $originalTitle): static
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): static
    {
        $this->overview = $overview;

        return $this;
    }

    public function getPopularity(): ?float
    {
        return $this->popularity;
    }

    public function setPopularity(?float $popularity): static
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getVoteAverage(): ?float
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(?float $voteAverage): static
    {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    public function getVoteCount(): ?int
    {
        return $this->voteCount;
    }

    public function setVoteCount(?int $voteCount): static
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getImdbId(): ?string
    {
        return $this->imdbId;
    }

    public function setImdbId(?string $imdbId): static
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    public function getRevenue(): ?int
    {
        return $this->revenue;
    }

    public function setRevenue(?int $revenue): static
    {
        $this->revenue = $revenue;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    public function setTagline(?string $tagline): static
    {
        $this->tagline = $tagline;

        return $this;
    }

    public function isVideo(): ?bool
    {
        return $this->video;
    }

    public function setVideo(?bool $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(?int $tmdbId): static
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }

    public function getOriginalLanguage(): ?Language
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(?Language $originalLanguage): static
    {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }

    /**
     * @return Collection<int, MovieGenre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(MovieGenre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(MovieGenre $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getOriginCountries(): Collection
    {
        return $this->originCountries;
    }

    public function addOriginCountry(Country $originCountry): static
    {
        if (!$this->originCountries->contains($originCountry)) {
            $this->originCountries->add($originCountry);
        }

        return $this;
    }

    public function removeOriginCountry(Country $originCountry): static
    {
        $this->originCountries->removeElement($originCountry);

        return $this;
    }
}
