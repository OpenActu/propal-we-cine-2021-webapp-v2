<?php

namespace App\Service\TMDB\Manager;

use App\Entity\DTO\MovieGenreDTO;
use App\Contracts\PaginatorInterface;
use App\Service\RemoteWebService;
use FOPG\Component\UtilsBundle\Collection\Collection;
use FOPG\Component\UtilsBundle\Env\Env;
use FOPG\Component\UtilsBundle\Uri\Uri;
use Symfony\Component\HttpFoundation\Response;
class MovieGenreManager extends AbstractManager {

  private static function populate_find_all_from_remote_api(array $data): Collection {
    $collection = new Collection();
    if(!empty($data['genres'])) {
      $collection = new Collection(
        array: $data['genres'],
        callback: function(int $index, mixed $genre): mixed {
          return $genre['name'];
        },
        cmpAlgorithm: function($a,$b): bool { return ($a < $b); },
        callbackForValue: function(int $index, mixed $genre): mixed {
          $entity = new MovieGenreDTO();
          $entity->setId($genre['id']);
          $entity->setName($genre['name']);
          return $entity;
        }
      );

      $collection->heapSort();
    }
    return $collection;
  }

  public function findAll(int $offset=PaginatorInterface::DEFAULT_OFFSET, int $limit=PaginatorInterface::DEFAULT_LIMIT): Collection {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_GENRE_LIST'));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: ['api_key' => $this->getApiKey(),'language' => $this->getLocale()],
      ignoreJWT: false
    );

    return ($output['statusCode'] === Response::HTTP_OK) ? self::populate_find_all_from_remote_api($output['data']) : [];
  }
}