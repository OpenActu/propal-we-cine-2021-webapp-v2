<?php

namespace App\Entity\DTO;

use App\Controller\Movie\GetItem;
use App\Controller\Movie\SearchCollection;
use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};
use App\Utils\Collection\Collection;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\Metadata\Parameters;
use ApiPlatform\Metadata\QueryParameter;

#[ApiResource(
  operations: [
    new Get(
      uriTemplate: '/movie/{id}',
      controller: GetItem::class
    ),
    new GetCollection(
      uriTemplate: '/movie/search/',
      controller: SearchCollection::class,
      parameters:
        new Parameters([
          new QueryParameter(key: 'term', description: 'Term to find',required: true),
        ])
      ,
      openapi: new Operation(
        summary: 'Search movie from remote website',
        description: 'Search movie from remote website'
      )
    )
  ]
)]
class MovieDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use PathTrait;

  private Collection $movieGenres;
  private ?MovieCollectionDTO $belongsToCollection=null;
  private Collection $originCountries;
  private ?LanguageDTO $originalLanguage=null;
  private Collection $productionCompanies;
  private Collection $productionCountries;
  private Collection $spokenLanguages;

  public function __construct(
    int $id,
    string $title,
    ?string $posterPath=null,
    ?string $backdropPath=null,
    private bool $adult=false,
    ?string $originalLanguage=null,
    private ?string $originalTitle=null,
    private ?string $overview=null,
    private float $popularity=0,
    private ?\DateTime $releaseDate=null,
    private float $voteAverage=0,
    private float $voteCount=0,
    private ?int $budget=null,
    private ?string $homepage=null,
    private ?string $imdbId=null,
    private ?int $revenue=null,
    private ?int $runtime=null,
    private ?string $status=null,
    private ?string $tagline=null,
    private bool $video=false
  ){
    $this->spokenLanguages=new Collection();
    $this->movieGenres=new Collection();
    $this->originCountries=new Collection();
    $this->productionCompanies=new Collection();
    $this->productionCountries=new Collection();
    $this->setName($title);
    $this->setId($id);
    $this->setBackdropPath($backdropPath);
    $this->setPosterPath($posterPath);
    if(!empty($originalLanguage)) {
      $this->setOriginalLanguage(new LanguageDTO(code: $originalLanguage));
    }
  }

  public function getVideo(): bool { return $this->video; }
  public function getTagline(): ?string { return $this->tagline; }
  public function getStatus(): ?string { return $this->status; }
  public function getRuntime(): ?int { return $this->runtime; }
  public function getRevenue(): ?int { return $this->revenue; }
  public function getImdbId(): ?string { return $this->imdbId; }
  public function getHomepage(): ?string { return $this->homepage; }
  public function getBudget(): ?int { return $this->budget; }
  public function setBelongsToCollection(MovieCollectionDTO $collection): static { $this->belongsToCollection=$collection; return $this; }
  public function getBelongsToCollection(): ?MovieCollectionDTO { return $this->belongsToCollection; }
  public function getAdult(): bool { return $this->adult; }
  public function setOriginalLanguage(LanguageDTO $language): static { $this->originalLanguage = $language; return $this; }
  public function getOriginalLanguage(): ?LanguageDTO { return $this->originalLanguage; }
  public function getOriginalTitle(): ?string { return $this->originalTitle; }
  public function getOverview(): ?string { return $this->overview; }
  public function getPopularity(): float { return $this->popularity; }
  public function getReleaseDate(): ?\DateTime { return $this->releaseDate; }
  public function getTitle(): ?string { return $this->getName(); }
  public function getVoteAverage(): float { return $this->voteAverage; }
  public function getVoteCount(): float { return $this->voteCount; }
  public function addMovieGenre(MovieGenreDTO $movieGenre): static { $this->movieGenres->add($movieGenre); return $this; }
  public function getMovieGenres(): Collection { return $this->movieGenres; }
  public function addOriginCountry(CountryDTO $country): static { $this->originCountries->add($country); return $this; }
  public function getOriginCountries(): Collection { return $this->originCountries; }
  public function addProductionCompany(ProductionCompanyDTO $pc): static { $this->productionCompanies->add($pc); return $this; }
  public function getProductionCompanies(): Collection { return $this->productionCompanies; }
  public function addProductioncountry(CountryDTO $country): static { $this->productionCountries->add($country); return $this; }
  public function getProductionCountries(): Collection { return $this->productionCountries; }
  public function addSpokenLanguage(LanguageDTO $lg): static { $this->spokenLanguages->add($lg); return $this; }
  public function getSpokenLanguages(): Collection { return $this->spokenLanguages; }

  public function serializeToArray(): array {
    return [
      'id' => $this->getId(),
      'title' => $this->getTitle(),
      'adult' => $this->getAdult(),
      'originalTitle' => $this->getOriginalTitle(),
      'overview' => $this->getOverview(),
      'popularity' => $this->getPopularity(),
      'releaseYear' => $this->getReleaseDate() ? $this->getReleaseDate()->format('Y') : null,
      'releaseDate' => $this->getReleaseDate() ? $this->getReleaseDate()->format('Y-m-d') : null,
      'voteAverage' => $this->getVoteAverage(),
      'voteCount' => $this->getVoteCount(),
      'budget' => number_format($this->getBudget(),0,""," "),
      'homepage' => $this->getHomepage(),
      'imdbId' => $this->getImdbId(),
      'revenue' => number_format($this->getRevenue(),0,""," "),
      'runtime' => $this->getRuntime(),
      'status' => $this->getStatus(),
      'tagline' => $this->getTagline(),
      'video' => $this->getVideo(),
      'originalLanguage' => $this->getOriginalLanguage() ? $this->getOriginalLanguage()->serializeToArray() : null,
      'movieGenres' => $this->getMovieGenres()->serializeToArray(),
      'belongsToCollection' => $this->getBelongsToCollection() ? $this->getBelongsToCollection()->serializeToArray() : null,
      'originCountries' => $this->getOriginCountries()->serializeToArray(),
      'productionCompanies' => $this->getProductionCompanies()->serializeToArray(),
      'productionCountries' => $this->getProductionCountries()->serializeToArray(),
      'spokenLanguages' => $this->getSpokenLanguages()->serializeToArray(),
    ];
  }
}
