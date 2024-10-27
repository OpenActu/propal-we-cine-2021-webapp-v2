<?php

namespace App\Service\TMDB\Manager;

use App\Contracts\SearchInterface;
use App\Entity\DTO\MovieDTO;
use App\Service\TMDB\Manager\Trait\Movie\ConverterTrait;
use App\Service\TMDB\Manager\Trait\SearchManagerTrait;
use FOPG\Component\UtilsBundle\Collection\Collection;
use FOPG\Component\UtilsBundle\String\StringFacility;
use FOPG\Component\UtilsBundle\Env\Env;
use Symfony\Component\HttpFoundation\Response;

class MovieManager extends AbstractManager {

  use ConverterTrait;
  use SearchManagerTrait;

  public function findAll(int $page=SearchInterface::DEFAULT_PAGE, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
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

  public function search(string $query, int $page=SearchInterface::DEFAULT_PAGE, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_LIST_SEARCH'));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: ['api_key' => $this->getApiKey(),'language' => $this->getLocale(),'query' => $query, 'page' => $page],
      ignoreJWT: true
    );
    if($output['statusCode'] == Response::HTTP_OK) {
      $collection = self::convert_array_to_collection($output['data']);
      $this->setTotalPages($output['data']['total_pages']);
      $this->setTotalResults($output['data']['total_results']);
      return $collection;
    }
    return null;
  }

  public function findBy(array $params=[], array $sortBy=[], int $page=SearchInterface::DEFAULT_PAGE, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var Uri $uri */
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_LIST'));
    /** @var array $output */
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: array_merge(
        ['api_key' => $this->getApiKey(),'language' => $this->getLocale(),'page' => $page],
        $params,
        self::generate_sort_params($sortBy)
      ),
      ignoreJWT: true
    );
    if($output['statusCode'] == Response::HTTP_OK) {
      $collection = self::convert_array_to_collection($output['data'],$limit);
      $this->setTotalPages($output['data']['total_pages']);
      $this->setTotalResults($output['data']['total_results']);
    }
    return $collection;
  }

  public function find(int $id): ?MovieDTO {
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
      $entity = self::convert_array_to_entity($output['data']);
      return $entity;
    }
    return null;
  }
}
