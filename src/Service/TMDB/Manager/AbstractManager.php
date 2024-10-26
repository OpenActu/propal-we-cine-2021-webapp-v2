<?php

namespace App\Service\TMDB\Manager;

use App\Contracts\{LocalizationInterface,SearchInterface};
use App\Service\RemoteWebService;
use App\Service\TMDB\Manager\Trait\LocalizationManagerTrait;
use FOPG\Component\UtilsBundle\Uri\Uri;
use FOPG\Component\UtilsBundle\Env\Env;

abstract class AbstractManager implements LocalizationInterface, SearchInterface {

  use LocalizationManagerTrait;

  private ?string $apiKey=null;

  public function __construct(
    private RemoteWebService $rws,
    private Uri $uri=new Uri()
  ) {
    $this->apiKey=Env::get('TMDB_API_KEY');
    $this->uri->sanitize(Env::get('TMDB_REMOTE_URL'));
    /** @todo manage locale */
  }

  public function getApiKey():string { return $this->apiKey; }
  public function getRemoteWebService():RemoteWebService { return $this->rws; }
  public function getUri(): Uri { return $this->uri; }
}
