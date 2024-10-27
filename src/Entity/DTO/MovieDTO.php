<?php

namespace App\Entity\DTO;

use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};

class MovieDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use PathTrait;

  private array $movieGenres=[];
  private ?MovieCollectionDTO $belongsToCollection=null;
  private array $originCountries=[];
  private ?LanguageDTO $originalLanguage=null;
  private array $productionCompanies=[];
  private array $productionCountries=[];
  private array $spokenLanguages=[];

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
  public function addMovieGenre(MovieGenreDTO $movieGenre): static {
    $this->movieGenres[$movieGenre->getId()]=$movieGenre;
    return $this;
  }
  public function getMovieGenres(): array { return $this->movieGenres; }
  public function addOriginCountry(CountryDTO $country): static { $this->originCountries[]=$country; return $this; }
  public function getOriginCountries(): array { return $this->originCountries; }
  public function addProductionCompany(ProductionCompanyDTO $pc): static { $this->productionCompanies[]=$pc; return $this; }
  public function getProductionCompanies(): array { return $this->productionCompanies; }
  public function addProductioncountry(CountryDTO $country): static { $this->productionCountries[]=$country; return $this; }
  public function getProductionCountries(): array { return $this->productionCountries; }
  public function addSpokenLanguage(LanguageDTO $lg): static { $this->spokenLanguages[]=$lg; return $this; }
  public function getSpokenLanguages(): array { return $this->spokenLanguages; }

  public function serializeToArray(): array {
    $movieGenres=[];
    foreach($this->getMovieGenres() as $movieGenre)
      $movieGenres[]=$movieGenre->serializeToArray();
    $originCountries=[];
    foreach($this->getOriginCountries() as $originCountry)
      $originCountries[]=$originCountry->serializeToArray();
    $productionCompanies=[];
    foreach($this->getProductionCompanies() as $productionCompany)
      $productionCompanies[]=$productionCompany->serializeToArray();
    $productionCountries=[];
    foreach($this->getProductionCountries() as $productionCountry)
      $productionCountries[]=$productionCountry->serializeToArray();
    $spokenLanguages=[];
    foreach($this->getSpokenLanguages() as $spokenLanguage)
      $spokenLanguages[]=$spokenLanguage->serializeToArray();
    return [
      'id' => $this->getId(),
      'title' => $this->getTitle(),
      'adult' => $this->getAdult(),
      'originalTitle' => $this->getOriginalTitle(),
      'overview' => $this->getOverview(),
      'popularity' => $this->getPopularity(),
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
      'movieGenres' => $movieGenres,
      'belongsToCollection' => $this->getBelongsToCollection() ? $this->getBelongsToCollection()->serializeToArray() : null,
      'originCountries' => $originCountries,
      'productionCompanies' => $productionCompanies,
      'productionCountries' => $productionCountries,
      'spokenLanguages' => $spokenLanguages,
    ];
  }
}
