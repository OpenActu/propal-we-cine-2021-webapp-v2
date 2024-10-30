<?php

namespace App\Service\TMDB\Manager\Trait\Image;

use App\Contracts\SearchInterface;
use App\Contracts\EntityDTOInterface;
use App\Utils\Collection\Collection;

trait ConverterTrait {
  public static function convert_array_to_collection(array $data,int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    throw new \Exception('@todo à implémenter');
  }

  public static function convert_array_to_entity(array $data): EntityDTOInterface {
    throw new \Exception('@todo à implémenter');
  }
}
