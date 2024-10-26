<?php

namespace App\Service\TMDB;

use App\Contracts\PaginatorInterface;
use App\Service\RemoteWebService;
use FOPG\Component\UtilsBundle\Env\Env;

class MovieGenreManager extends AbstractManager {
  public function findAll(int $offset=PaginatorInterface::DEFAULT_OFFSET, int $limit=PaginatorInterface::DEFAULT_LIMIT): array {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    $uri = $this->getUri()->setPath(Env::get('TMDB_API_MOVIE_GENRE_LIST'));
    $output = $rws->call(
      remoteUrl: $this->getUri(),
      params: ['api_key' => $this->getApiKey(),'language' => 'fr'],
      ignoreJWT: false
    );
    dd($output);
    return [];
  }
}
