<?php

namespace App\Service\TMDB\Manager\Trait\Movie;

use App\Contracts\SearchInterface;
use App\Entity\DTO\{CountryDTO, LanguageDTO, MovieDTO, MovieCollectionDTO, MovieGenreDTO, ProductionCompanyDTO};
use App\Utils\Collection\Collection;

trait ConverterTrait {

  public static function convert_array_to_collection(array $data, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var Collection $collection */
    $collection = new Collection();
    if(!empty($data['results'])) {
      $collection = new Collection(
        array: array_slice($data['results'],0,$limit),
        callback: function(int $index, array $movie): string {
          return $movie['popularity'];
        },
        cmpAlgorithm: function($a,$b): bool { return ($a < $b); },
        callbackForValue: function(int $index, array $movie): MovieDTO {
          return self::convert_array_to_entity($movie);
        }
      );
    }
    return $collection;
  }

  public static function convert_array_to_entity(array $movie): MovieDTO {
    /** @var MovieDTO $entity */
    $entity = new MovieDTO(
      id: $movie['id'],
      title: $movie['title'],
      adult: $movie['adult']??false,
      backdropPath: $movie['backdrop_path']??null,
      originalLanguage: $movie['original_language']??null,
      originalTitle: $movie['original_title']??null,
      overview: $movie['overview']??null,
      popularity: $movie['popularity']??0,
      posterPath: $movie['poster_path']??null,
      releaseDate: $movie['release_date'] ? new \DateTime($movie['release_date']) : null,
      voteAverage: $movie['vote_average']??0,
      voteCount: $movie['vote_count']??0,
      budget: $movie['budget']??null,
      homepage: $movie['homepage']??null,
      imdbId: $movie['imdb_id']??null,
      revenue: $movie['revenue']??null,
      runtime: $movie['runtime']??null,
      status: $movie['status']??null,
      tagline: $movie['tagline']??null,
      video: $movie['video']??false
    );

    if(!empty($movie['belongs_to_collection'])) {
      $collection = $movie['belongs_to_collection'];
      $entity->setBelongsToCollection(new MovieCollectionDTO(id: $collection['id'],name: $collection['name'], posterPath: $collection['poster_path'], backdropPath: $collection['backdrop_path']));
    }

    if(!empty($movie['genre_ids']))
      foreach($movie['genre_ids'] as $movieGenreId)
        $entity->addGenre(new MovieGenreDTO(id: $movieGenreId));

    if(!empty($movie['genres']))
      foreach($movie['genres'] as $genre)
        $entity->addGenre(new MovieGenreDTO(id: $genre['id'],name: $genre['name']));

    if(!empty($movie['origin_country']))
      foreach($movie['origin_country'] as $code)
        $entity->addOriginCountry(new CountryDTO(code: $code));

    if(!empty($movie['production_companies'])) {
      foreach($movie['production_companies'] as $pc) {
        $obj = new ProductionCompanyDTO(id: $pc['id'],name: $pc['name'],logoPath: $pc['logo_path']);
        $obj->setOriginCountry(new CountryDTO(code: $pc['origin_country']));
        $entity->addProductionCompany($obj);
      }
    }

    if(!empty($movie['production_countries']))
      foreach($movie['production_countries'] as $pc)
        $entity->addProductionCountry(new CountryDTO(code: $pc['iso_3166_1'],name: $pc['name']));

    if(!empty($movie['spoken_languages']))
      foreach($movie['spoken_languages'] as $sl)
        $entity->addSpokenLanguage(new LanguageDTO(name: $sl['name'],code: $sl['iso_639_1'], englishName: $sl['english_name']));

    return $entity;
  }
}
