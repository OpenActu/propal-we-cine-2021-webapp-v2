<?php
namespace App\Contracts\Entity;

use App\Contracts\{EntityInterface, LocalizationInterface};
use App\Contracts\DesignPattern\BuilderInstanceInterface;

interface MovieInterface extends LocalizationInterface, BuilderInstanceInterface {
    public function isVideo(): ?bool;
    public function getTagline(): ?string;
    public function getStatus(): ?string;
    public function getRuntime(): ?int;
    public function getRevenue(): ?int;
    public function getImdbId(): ?string;
    public function getHomepage(): ?string;
    public function getBudget(): ?int;
    public function getTmdbId(): ?int;
    public function setBelongsToCollection(MovieCollectionInterface $collection): EntityInterface;
    public function getBelongsToCollection(): ?MovieCollectionInterface;
    public function isAdult(): ?bool;
    public function setOriginalLanguage(LanguageInterface $language): EntityInterface;
    public function getOriginalLanguage(): ?LanguageInterface;
    public function getOriginalTitle(): ?string;
    public function getOverview(): ?string;
    public function getPopularity(): float;
    public function getReleaseDate(): ?\DateTimeInterface;
    public function getTitle(): ?string;
    public function getVoteAverage(): float;
    public function getVoteCount(): int;
    public function addGenre(MovieGenreInterface $movieGenre): EntityInterface;
    public function getGenres(): mixed;
    public function addOriginCountry(CountryInterface $country): EntityInterface;
    public function getOriginCountries(): mixed;
    public function addProductionCompany(ProductionCompanyInterface $pc): EntityInterface;
    public function getProductionCompanies(): mixed;
    public function addProductioncountry(CountryInterface $country): EntityInterface;
    public function getProductionCountries(): mixed;
    public function addSpokenLanguage(LanguageInterface $lg): EntityInterface;
    public function getSpokenLanguages(): mixed;
}