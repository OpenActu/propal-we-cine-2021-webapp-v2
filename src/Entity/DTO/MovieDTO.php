<?php

namespace App\Entity\DTO;

use App\Contracts\EntityInterface;
use App\Contracts\Entity\{CountryInterface,LanguageInterface,MovieCollectionInterface,MovieGenreInterface,MovieInterface,ProductionCompanyInterface};
use App\Controller\Movie\GetItem;
use App\Controller\Movie\SearchCollection;
use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};
use App\Entity\Trait\Movie\SerializerTrait;
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
      uriTemplate: '/movie_dto/{id}',
      controller: GetItem::class
    ),
    new GetCollection(
      uriTemplate: '/movie_dto/search/',
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
class MovieDTO extends AbstractEntityDTO implements MovieInterface {

  use IdentifierTrait;
  use PathTrait;
  use SerializerTrait;

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
    private ?bool $adult=null,
    ?string $originalLanguage=null,
    private ?string $originalTitle=null,
    private ?string $overview=null,
    private float $popularity=0,
    private ?\DateTime $releaseDate=null,
    private float $voteAverage=0,
    private int $voteCount=0,
    private ?int $budget=null,
    private ?string $homepage=null,
    private ?string $imdbId=null,
    private ?int $revenue=null,
    private ?int $runtime=null,
    private ?string $status=null,
    private ?string $tagline=null,
    private ?bool $video=null
  ){
    $this->spokenLanguages=new Collection();
    $this->movieGenres=new Collection();
    $this->originCountries=new Collection();
    $this->productionCompanies=new Collection();
    $this->productionCountries=new Collection();
    $this->setName($title);
    $this->setId($id);
    if($backdropPath)
      $this->setBackdrop(new ImageDTO(filename: $backdropPath));
    if($posterPath)
      $this->setPoster(new ImageDTO(filename: $posterPath));
    if(!empty($originalLanguage)) {
      $this->setOriginalLanguage(new LanguageDTO(code: $originalLanguage));
    }
  }

  public function isVideo(): ?bool { return $this->video; }
  public function getTagline(): ?string { return $this->tagline; }
  public function getStatus(): ?string { return $this->status; }
  public function getRuntime(): ?int { return $this->runtime; }
  public function getRevenue(): ?int { return $this->revenue; }
  public function getImdbId(): ?string { return $this->imdbId; }
  public function getHomepage(): ?string { return $this->homepage; }
  public function getBudget(): ?int { return $this->budget; }
  public function setBelongsToCollection(MovieCollectionInterface $collection): EntityInterface { $this->belongsToCollection=$collection; return $this; }
  public function getBelongsToCollection(): ?MovieCollectionInterface { return $this->belongsToCollection; }
  public function isAdult(): ?bool { return $this->adult; }
  public function setOriginalLanguage(LanguageInterface $language): EntityInterface { $this->originalLanguage = $language; return $this; }
  public function getOriginalLanguage(): ?LanguageInterface { return $this->originalLanguage; }
  public function getOriginalTitle(): ?string { return $this->originalTitle; }
  public function getOverview(): ?string { return $this->overview; }
  public function getPopularity(): float { return $this->popularity; }
  public function getReleaseDate(): ?\DateTime { return $this->releaseDate; }
  public function getTitle(): ?string { return $this->getName(); }
  public function getVoteAverage(): float { return $this->voteAverage; }
  public function getVoteCount(): int { return $this->voteCount; }
  public function addGenre(MovieGenreInterface $movieGenre): EntityInterface { $this->movieGenres->add($movieGenre); return $this; }
  public function getGenres(): Collection { return $this->movieGenres; }
  public function addOriginCountry(CountryInterface $country): EntityInterface { $this->originCountries->add($country); return $this; }
  public function getOriginCountries(): Collection { return $this->originCountries; }
  public function addProductionCompany(ProductionCompanyInterface $pc): EntityInterface { $this->productionCompanies->add($pc); return $this; }
  public function getProductionCompanies(): Collection { return $this->productionCompanies; }
  public function addProductioncountry(CountryInterface $country): EntityInterface { $this->productionCountries->add($country); return $this; }
  public function getProductionCountries(): Collection { return $this->productionCountries; }
  public function addSpokenLanguage(LanguageInterface $lg): EntityInterface { $this->spokenLanguages->add($lg); return $this; }
  public function getSpokenLanguages(): Collection { return $this->spokenLanguages; }
}
