<?php

namespace App\Service\TMDB\Manager;

use App\Contracts\{SearchInterface, EntityDTOInterface};
use App\Service\RemoteWebService;
use App\Service\TMDB\Manager\Trait\Image\ConverterTrait;
use FOPG\Component\UtilsBundle\Collection\Collection;
use App\Utils\Env\Env;
use FOPG\Component\UtilsBundle\Uri\Uri;
use Symfony\Component\HttpFoundation\Response;

class ImageManager extends AbstractManager {

  use ConverterTrait;

  public function findAll(int $page=SearchInterface::DEFAULT_PAGE, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    throw new \Exception("@todo à implémenter");
  }

  public function findBy(array $params=[], array $sortBy=[], int $page=SearchInterface::DEFAULT_PAGE, int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    throw new \Exception("@todo à implémenter");
  }

  public function find(int $id): ?EntityDTOInterface {
    throw new \Exception("@todo à implémenter");
  }

  public static function generate_url_by_format_and_filename(string $format, string $filename): string {
    $url = Env::get('TMDB_CDN').'/';
    switch($format) {
      case 'w500':
        $url.=Env::get('TMDB_CDN_W500').'/';
        break;
      case 'original':
        $url.=Env::get('TMDB_CDN_ORIGINAL').'/';
        break;
      default:
        throw new \Exception('format '.$format.' inconnu');
    }
    return $url.=preg_replace("/^\/+/","",$filename);
  }

  public function download(string $format, string $filename): ?string {
    /** @var RemoteWebService $rws */
    $rws = $this->getRemoteWebService();
    /** @var string $url */
    $url = self::generate_url_by_format_and_filename($format,$filename);
    /** @var Uri $uri */
    $uri = $this->getUri()->sanitize($url);
    /** @var array $output */
    $output = $rws->call(remoteUrl: $uri);
    if($output['statusCode'] == Response::HTTP_OK)
      return $output['response'];
    return null;
  }
}
