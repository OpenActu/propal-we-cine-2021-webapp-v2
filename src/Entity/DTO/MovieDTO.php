<?php

namespace App\Entity\DTO;

use App\Contracts\EntityDTOInterface;

class MovieDTO implements EntityDTOInterface {

  use BasisTrait;

  private array $movieGenres=[];

  public function __construct(
    int $id,
    string $title,
    private bool $adult=false,
    private ?string $backdropPath=null,
    private ?string $originalLanguage=null,
    private ?string $originalTitle=null,
    private ?string $overview=null,
    private float $popularity=0,
    private ?string $posterPath=null,
    private ?\DateTime $releaseDate=null,
    private float $voteAverage=0,
    private float $voteCount=0
  ){
    $this->setName($title);
    $this->setId($id);
  }

  public function getAdult(): bool { return $this->adult; }
  public function getBackdropPath(): ?string { return $this->backdropPath; }
  public function getOriginalLanguage(): ?string { return $this->originalLanguage; }
  public function getOriginalTitle(): ?string { return $this->originalTitle; }
  public function getOverview(): ?string { return $this->overview; }
  public function getPopularity(): float { return $this->popularity; }
  public function getPosterPath(): ?string { return $this->posterPath; }
  public function getReleaseDate(): ?\DateTime { return $this->releaseDate; }
  public function getTitle(): ?string { return $this->getName(); }
  public function getVoteAverage(): float { return $this->voteAverage; }
  public function getVoteCount(): float { return $this->voteCount; }
  public function addMovieGenre(MovieGenreDTO $movieGenre): static {
    $this->movieGenres[$movieGenre->getId()]=$movieGenre;
    return $this;
  }
  public function getMovieGenres(): array { return $this->movieGenres; }
}
