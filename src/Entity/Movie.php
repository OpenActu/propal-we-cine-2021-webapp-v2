<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Contracts\Entity\{CountryInterface,LanguageInterface,MovieCollectionInterface,MovieGenreInterface,MovieInterface,ProductionCompanyInterface};
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
class Movie implements ReceiverDTOInterface, EntityInterface, MovieInterface
{
    use ReceiverDTOTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['api_movie_dto_GET_item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[Groups(['api_movie_dto_GET_item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?bool $adult = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?string $originalTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?string $overview = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['api_movie_dto_GET_item'])]
    private float $popularity = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['api_movie_dto_GET_item'])]
    private float $voteAverage = 0;

    #[ORM\Column(nullable: false)]
    #[Groups(['api_movie_dto_GET_item'])]
    private int $voteCount = 0;

    #[ORM\Column(nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?int $budget = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?string $imdbId = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?int $revenue = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?string $tagline = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?bool $video = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?int $tmdbId = null;

    #[ORM\ManyToOne]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?Language $originalLanguage = null;

    /**
     * @var Collection<int, MovieGenre>
     */
    #[ORM\ManyToMany(targetEntity: MovieGenre::class)]
    #[Groups(['api_movie_dto_GET_item'])]
    private Collection $genres;

    /**
     * @var Collection<int, Country>
     */
    #[ORM\ManyToMany(targetEntity: Country::class)]
    private Collection $originCountries;

    #[ORM\Column(nullable: true)]
    private ?int $runtime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $homepage = null;

    #[ORM\ManyToOne]
    #[Groups(['api_movie_dto_GET_item'])]
    private ?MovieCollection $belongsToCollection = null;

    /**
     * @var Collection<int, ProductionCompany>
     */
    #[ORM\ManyToMany(targetEntity: ProductionCompany::class)]
    private Collection $productionCompanies;

    /**
     * @var Collection<int, Country>
     */
    #[ORM\ManyToMany(targetEntity: Country::class)]
    #[ORM\JoinTable(name: 'movie_production_country')]
    private Collection $productionCountries;

    /**
     * @var Collection<int, Language>
     */
    #[ORM\ManyToMany(targetEntity: Language::class)]
    private Collection $spokenLanguages;

    #[ORM\Column(length: 255)]
    private ?string $locale = null;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->originCountries = new ArrayCollection();
        $this->productionCompanies = new ArrayCollection();
        $this->productionCountries = new ArrayCollection();
        $this->spokenLanguages = new ArrayCollection();
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

    public function getPopularity(): float
    {
        return $this->popularity;
    }

    public function setPopularity(float $popularity): static
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

    public function getVoteAverage(): float
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(float $voteAverage): static
    {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    public function getVoteCount(): int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): static
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

    public function getOriginalLanguage(): ?LanguageInterface
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(?LanguageInterface $originalLanguage): static
    {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }

    /**
     * @return Collection<int, MovieGenreInterface>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(MovieGenreInterface $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(MovieGenreInterface $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, CountryInterface>
     */
    public function getOriginCountries(): Collection
    {
        return $this->originCountries;
    }

    public function addOriginCountry(CountryInterface $originCountry): static
    {
        if (!$this->originCountries->contains($originCountry)) {
            $this->originCountries->add($originCountry);
        }

        return $this;
    }

    public function removeOriginCountry(CountryInterface $originCountry): static
    {
        $this->originCountries->removeElement($originCountry);

        return $this;
    }

    public function getRuntime(): ?int
    {
        return $this->runtime;
    }

    public function setRuntime(?int $runtime): static
    {
        $this->runtime = $runtime;

        return $this;
    }

    public function getHomepage(): ?string
    {
        return $this->homepage;
    }

    public function setHomepage(?string $homepage): static
    {
        $this->homepage = $homepage;

        return $this;
    }

    public function getBelongsToCollection(): ?MovieCollectionInterface
    {
        return $this->belongsToCollection;
    }

    public function setBelongsToCollection(?MovieCollectionInterface $belongsToCollection): static
    {
        $this->belongsToCollection = $belongsToCollection;

        return $this;
    }

    /**
     * @return Collection<int, ProductionCompanyInterface>
     */
    public function getProductionCompanies(): Collection
    {
        return $this->productionCompanies;
    }

    public function addProductionCompany(ProductionCompanyInterface $productionCompany): static
    {
        if (!$this->productionCompanies->contains($productionCompany)) {
            $this->productionCompanies->add($productionCompany);
        }

        return $this;
    }

    public function removeProductionCompany(ProductionCompanyInterface $productionCompany): static
    {
        $this->productionCompanies->removeElement($productionCompany);

        return $this;
    }

    /**
     * @return Collection<int, CountryInterface>
     */
    public function getProductionCountries(): Collection
    {
        return $this->productionCountries;
    }

    public function addProductionCountry(CountryInterface $productionCountry): static
    {
        if (!$this->productionCountries->contains($productionCountry)) {
            $this->productionCountries->add($productionCountry);
        }

        return $this;
    }

    public function removeProductionCountry(CountryInterface $productionCountry): static
    {
        $this->productionCountries->removeElement($productionCountry);

        return $this;
    }

    /**
     * @return Collection<int, LanguageInterface>
     */
    public function getSpokenLanguages(): Collection
    {
        return $this->spokenLanguages;
    }

    public function addSpokenLanguage(LanguageInterface $spokenLanguage): static
    {
        if (!$this->spokenLanguages->contains($spokenLanguage)) {
            $this->spokenLanguages->add($spokenLanguage);
        }

        return $this;
    }

    public function removeSpokenLanguage(LanguageInterface $spokenLanguage): static
    {
        $this->spokenLanguages->removeElement($spokenLanguage);

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }
}
