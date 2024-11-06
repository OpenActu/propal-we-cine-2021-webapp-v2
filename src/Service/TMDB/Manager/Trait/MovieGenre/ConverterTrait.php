<?php

namespace App\Service\TMDB\Manager\Trait\MovieGenre;

use App\Contracts\SearchInterface;
use App\Entity\DTO\MovieGenreDTO;
use App\Utils\Collection\Collection;

trait ConverterTrait {

  public static function convert_array_to_entity(array $data): MovieGenreDTO {
    throw new \Exception('@todo à implémenter');
  }

  public static function convert_array_to_collection(array $data,int $limit=SearchInterface::DEFAULT_LIMIT): Collection {
    /** @var Collection $collection */
    $collection = new Collection();
    if(!empty($data['genres'])) {
      $collection = new Collection(
        array: $data['genres'],
        callback: function(int $index, array $genre): string {
          return $genre['name'];
        },
        cmpAlgorithm: function($a,$b): bool { return ($a < $b); },
        callbackForValue: function(int $index, array $genre): MovieGenreDTO {
          return MovieGenreDTO::getInstance(id: $genre['id'],name: $genre['name']);
        }
      );
      /** Tri rapide */
      $collection->heapSort();
    }
    return $collection;
  }
}
