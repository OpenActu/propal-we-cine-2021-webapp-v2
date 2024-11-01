<?php
namespace App\Contracts\Entity;

use App\Contracts\{CollectionInterface,EntityInterface};

interface MovieInterface {
    public function getVideo(): bool;
    public function getTagline(): ?string;
    public function getStatus(): ?string;
    public function getRuntime(): ?int;
    public function getRevenue(): ?int;
    public function getImdbId(): ?string;
    public function getHomepage(): ?string;
    public function getBudget(): ?int;
    public function setBelongsToCollection(MovieCollectionInterface $collection): EntityInterface;
    public function getBelongsToCollection(): ?MovieCollectionInterface;
    public function getAdult(): bool;
    public function setOriginalLanguage(LanguageInterface $language): EntityInterface;
    public function getOriginalLanguage(): ?LanguageInterface;
    public function getOriginalTitle(): ?string;
    public function getOverview(): ?string;
    public function getPopularity(): float;
    public function getReleaseDate(): ?\DateTime;
    public function getTitle(): ?string;
    public function getVoteAverage(): float;
    public function getVoteCount(): float;
    public function addMovieGenre(MovieGenreInterface $movieGenre): EntityInterface;
    public function getMovieGenres(): CollectionInterface;
    public function addOriginCountry(CountryInterface $country): EntityInterface;
    public function getOriginCountries(): CollectionInterface;
    public function addProductionCompany(ProductionCompanyInterface $pc): EntityInterface;
    public function getProductionCompanies(): CollectionInterface;
    public function addProductioncountry(CountryInterface $country): EntityInterface;
    public function getProductionCountries(): CollectionInterface;
    public function addSpokenLanguage(LanguageInterface $lg): EntityInterface;
    public function getSpokenLanguages(): CollectionInterface;
}