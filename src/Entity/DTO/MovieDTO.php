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
use Symfony\Component\Serializer\Annotation\Groups;
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
  #[Groups(['global_dto_read'])]
  private string $title;
  #[Groups(['global_dto_read'])]
  private string $locale;
  #[Groups(['global_dto_read'])]
  private ?bool $adult=null;
  #[Groups(['global_dto_read'])]
  private ?string $originalTitle=null;
  #[Groups(['global_dto_read'])]
  private ?string $overview=null;
  #[Groups(['global_dto_read'])]
  private float $popularity=0;
  #[Groups(['global_dto_read'])]
  private ?\DateTime $releaseDate=null;
  #[Groups(['global_dto_read'])]
  private float $voteAverage=0;
  #[Groups(['global_dto_read'])]
  private int $voteCount=0;
  #[Groups(['global_dto_read'])]
  private ?int $budget=null;
  #[Groups(['global_dto_read'])]
  private ?string $homepage=null;
  #[Groups(['global_dto_read'])]
  private ?string $imdbId=null;
  #[Groups(['global_dto_read'])]
  private ?int $revenue=null;
  #[Groups(['global_dto_read'])]
  private ?int $runtime=null;
  #[Groups(['global_dto_read'])]
  private ?string $status=null;
  #[Groups(['global_dto_read'])]
  private ?string $tagline=null;
  #[Groups(['global_dto_read'])]
  private ?bool $video=null;
  
  public function __construct(
    int $id,
    string $title,
    string $locale,
    ?string $posterPath=null,
    ?string $backdropPath=null,
    ?bool $adult=null,
    ?string $originalLanguage=null,
    ?string $originalTitle=null,
    ?string $overview=null,
    float $popularity=0,
    ?\DateTime $releaseDate=null,
    float $voteAverage=0,
    int $voteCount=0,
    ?int $budget=null,
    ?string $homepage=null,
    ?string $imdbId=null,
    ?int $revenue=null,
    ?int $runtime=null,
    ?string $status=null,
    ?string $tagline=null,
    ?bool $video=null
  ){
    $this->spokenLanguages=new Collection();
    $this->movieGenres=new Collection();
    $this->originCountries=new Collection();
    $this->productionCompanies=new Collection();
    $this->productionCountries=new Collection();
    $this->setName($title);
    $this->setLocale($locale);
    $this->setId($id);
    $this->setAdult($adult);
    $this->setOriginalTitle($originalTitle);
    if($backdropPath)
      $this->setBackdrop(new ImageDTO(filename: $backdropPath));
    if($posterPath)
      $this->setPoster(new ImageDTO(filename: $posterPath));
    if(!empty($originalLanguage)) {
      $this->setOriginalLanguage(new LanguageDTO(code: $originalLanguage));
    }
    $this->setOverview($overview);
    $this->setPopularity($popularity);
    $this->setReleaseDate($releaseDate);
    $this->setVoteAverage($voteAverage);
    $this->setVoteCount($voteCount);
    $this->setBudget($budget);
    $this->setHomepage($homepage);
    $this->setImdbId($imdbId);
    $this->setRevenue($revenue);
    $this->setRuntime($runtime);
    $this->setStatus($status);
    $this->setTagline($tagline);
    $this->setVideo($video);
  }
  public function getLocale(): string { return $this->locale; }
  public function setLocale(string $locale): static { $this->locale=$locale; return $this; }
  public function getTmdbId(): ?int { return $this->id; }
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
  public function setAdult(?bool $adult): static { $this->adult=$adult; return $this; }
  public function setOriginalLanguage(LanguageInterface $language): EntityInterface { $this->originalLanguage = $language; return $this; }
  public function getOriginalLanguage(): ?LanguageInterface { return $this->originalLanguage; }
  public function getOriginalTitle(): ?string { return $this->originalTitle; }
  public function setOriginalTitle(?string $originalTitle): static { $this->originalTitle=$originalTitle; return $this; }
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
  public function setOverview(?string $overview): static { $this->overview=$overview; return $this; }
  public function setPopularity(float $popularity): static { $this->popularity=$popularity; return $this; }
  public function setReleaseDate(?\DateTime $releaseDate): static { $this->releaseDate=$releaseDate; return $this; }
  public function setVoteAverage(float $voteAverage): static { $this->voteAverage=$voteAverage; return $this; }
  public function setVoteCount(int $voteCount): static { $this->voteCount=$voteCount; return $this; }
  public function setBudget(?int $budget): static { $this->budget=$budget; return $this; }
  public function setHomepage(?string $homepage): static { $this->homepage=$homepage; return $this; }
  public function setImdbId(?string $imdbId): static { $this->imdbId=$imdbId; return $this; }
  public function setRevenue(?int $revenue): static { $this->revenue=$revenue; return $this; }
  public function setRuntime(?int $runtime): static { $this->runtime=$runtime; return $this; }
  public function setStatus(?string $status): static { $this->status=$status; return $this; }
  public function setTagline(?string $tagline): static { $this->tagline=$tagline; return $this; }
  public function setVideo(?bool $video): static { $this->video=$video; return $this; }
}
