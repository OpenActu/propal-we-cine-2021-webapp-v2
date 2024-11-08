<?php

namespace App\Service\TMDB\Manager;

use App\Entity\DTO\MovieGenreDTO;
use App\Contracts\{SearchInterface, EntityDTOInterface};
use App\Service\RemoteWebService;
use App\Service\TMDB\Manager\Trait\MovieGenre\ConverterTrait;
use App\Utils\Collection\Collection;
use App\Utils\Env\Env;
use App\Utils\Uri\Uri;
use Symfony\Component\HttpFoundation\Response;
use App\Contracts\Manager\MovieGenreManagerInterface; 

class MovieGenreManager extends AbstractManager implements MovieGenreManagerInterface {

  use ConverterTrait;

  public function findAll(int $page=SearchInterface::DEFAULT_PAGE, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_GENRE_LIST'));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: ['api_key' => $this->getApiKey(),'language' => $this->getLocale(),'page' => $page],
      ignoreJWT: false
    );

    return ($output['statusCode'] === Response::HTTP_OK) ? self::convert_array_to_collection($output['data']) : new Collection();
  }

  public function findBy(array $params=[], array $sortBy=[], int $page=SearchInterface::DEFAULT_PAGE, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    throw new \Exception("@todo à implémenter");
  }

  public function find(int $id): ?EntityDTOInterface {
    throw new \Exception("@todo à implémenter");
  }
}
