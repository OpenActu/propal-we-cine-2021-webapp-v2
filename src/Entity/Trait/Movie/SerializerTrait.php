<?php 
namespace App\Entity\Trait\Movie;

trait SerializerTrait {

  public function serializeToArray(): array {
    return [
      'id' => $this->getId(),
      'locale' => $this->getLocale(),
      'title' => $this->getTitle(),
      'adult' => $this->isAdult(),
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
      'video' => $this->isVideo(),
      'originalLanguage' => $this->getOriginalLanguage() ? $this->getOriginalLanguage()->serializeToArray() : null,
      'genres' => $this->getGenres()->serializeToArray(),
      'belongsToCollection' => $this->getBelongsToCollection() ? $this->getBelongsToCollection()->serializeToArray() : null,
      'originCountries' => $this->getOriginCountries()->serializeToArray(),
      'productionCompanies' => $this->getProductionCompanies()->serializeToArray(),
      'productionCountries' => $this->getProductionCountries()->serializeToArray(),
      'spokenLanguages' => $this->getSpokenLanguages()->serializeToArray(),
      'poster' => $this->getPoster()?$this->getPoster()->serializeToArray():null,
      'backdrop' => $this->getBackdrop()?$this->getBackdrop()->serializeToArray():null,
    ];
  }
}