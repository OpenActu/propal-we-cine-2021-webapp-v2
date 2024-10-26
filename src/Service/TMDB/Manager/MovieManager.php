<?php

namespace App\Service\TMDB\Manager;

use App\Contracts\SearchInterface;
use App\Entity\DTO\MovieDTO;
use App\Entity\DTO\MovieGenreDTO;
use FOPG\Component\UtilsBundle\Collection\Collection;
use FOPG\Component\UtilsBundle\Env\Env;

class MovieManager extends AbstractManager {

  public function findAll(int $offset=SearchInterface::DEFAULT_OFFSET, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    throw new \Exception("@todo à implémenter");
  }

  /**
   * Récupération des vidéos top rated par identifiant de catégorie
   *
   * @param int $movieGenreId Identifiant de genre de vidéos
   * @param int $offset Origine de la recherche
   * @param int $limit Nombre d'occurences renvoyées
   */
  public function findBy(array $params=[], int $offset=SearchInterface::DEFAULT_OFFSET, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_LIST'));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: array_merge(['api_key' => $this->getApiKey(),'language' => $this->getLocale()],$params),
      ignoreJWT: false
    );
    $collection = self::populate_find_by_from_remote_api($output['data']);
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
}
