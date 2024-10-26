<?php

namespace App\Service\TMDB\Manager;

use App\Contracts\{SearchInterface,EntityDTOInterface};
use App\Entity\DTO\{CountryDTO, LanguageDTO, MovieDTO, MovieCollectionDTO, MovieGenreDTO, ProductionCompanyDTO};
use App\Service\TMDB\Manager\Trait\SearchManagerTrait;
use FOPG\Component\UtilsBundle\Collection\Collection;
use FOPG\Component\UtilsBundle\String\StringFacility;
use FOPG\Component\UtilsBundle\Env\Env;
use Symfony\Component\HttpFoundation\Response;

class MovieManager extends AbstractManager {

  use SearchManagerTrait;

  public function findAll(int $offset=SearchInterface::DEFAULT_OFFSET, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    throw new \Exception("@todo à implémenter");
  }

  public static function generate_sort_params(array $params): array {
    $output=[];
    foreach($params as $key => $value) {
      switch($key) {
        case 'originalTitle':
        case 'popularity':
        case 'title':
        case 'voteAverage':
        case 'voteCount':
          if(in_array(mb_strtolower($value),[SearchInterface::SORT_ASC,SearchInterface::SORT_DESC]))
            $output['sort_by']=StringFacility::toSnakeCase("$key").'.'.mb_strtolower($value);
        default:
      }
    }
    return $output;
  }

  public function search(string $query, int $offset=SearchInterface::DEFAULT_OFFSET, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_LIST_SEARCH'));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: ['api_key' => $this->getApiKey(),'language' => $this->getLocale(),'query' => $query],
      ignoreJWT: true
    );
    if($output['statusCode'] == Response::HTTP_OK) {
      $collection = self::populate_find_by_from_remote_api($output['data']);
      $this->setTotalPages($output['data']['total_pages']);
      $this->setTotalResults($output['data']['total_results']);
      return $collection;
    }
    return null;
  }

  public function findBy(array $params=[], array $sortBy=[], int $offset=SearchInterface::DEFAULT_OFFSET, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_LIST'));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: array_merge(
        ['api_key' => $this->getApiKey(),'language' => $this->getLocale()],
        $params,
        self::generate_sort_params($sortBy)
      ),
      ignoreJWT: true
    );
    if($output['statusCode'] == Response::HTTP_OK) {
      $collection = self::populate_find_by_from_remote_api($output['data']);
      $this->setTotalPages($output['data']['total_pages']);
      $this->setTotalResults($output['data']['total_results']);
    }
    return $collection;
  }

  private static function populate_find_by_from_remote_api(array $data): Collection {
    /** @var Collection $collection */
    $collection = new Collection();
    if(!empty($data['results'])) {
      $collection = new Collection(
        array: $data['results'],
        callback: function(int $index, array $movie): string {
          return $movie['popularity'];
        },
        cmpAlgorithm: function($a,$b): bool { return ($a < $b); },
        callbackForValue: function(int $index, array $movie): MovieDTO {
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
            voteCount: $movie['vote_count']??0
          );

          foreach($movie['genre_ids'] as $movieGenreId)
            $entity->addMovieGenre(new MovieGenreDTO(id: $movieGenreId));

          return $entity;
        }
      );
    }
    return $collection;
  }

  public function find(int $id): ?EntityDTOInterface {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(str_replace("{{id}}",$id,Env::get('TMDB_API_MOVIE_DETAILS')));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      ignoreJWT: true,
      params: ['api_key' => $this->getApiKey(),'language' => $this->getLocale()]
    );
    if($output['statusCode'] == Response::HTTP_OK) {
      $entity = self::populate_find_from_remote_api($output['data']);
      return $entity;
    }
    return null;
  }

  private static function populate_find_from_remote_api(array $movie): MovieDTO {
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

    foreach($movie['genres'] as $genre)
      $entity->addMovieGenre(new MovieGenreDTO(id: $genre['id'],name: $genre['name']));
    foreach($movie['origin_country'] as $code)
      $entity->addOriginCountry(new CountryDTO(code: $code));
    foreach($movie['production_companies'] as $pc) {
      $obj = new ProductionCompanyDTO(id: $pc['id'],name: $pc['name'],logoPath: $pc['logo_path']);
      $obj->setOriginCountry(new CountryDTO(code: $pc['origin_country']));
      $entity->addProductionCompany($obj);
    }
    foreach($movie['production_countries'] as $pc)
      $entity->addProductionCountry(new CountryDTO(code: $pc['iso_3166_1'],name: $pc['name']));
    foreach($movie['spoken_languages'] as $sl)
      $entity->addSpokenLanguage(new LanguageDTO(name: $sl['name'],code: $sl['iso_639_1'], englishName: $sl['english_name']));
    return $entity;
  }
}
