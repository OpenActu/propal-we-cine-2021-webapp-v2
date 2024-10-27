<?php

namespace App\Service\TMDB\Manager\Trait\MovieGenre;

use App\Entity\DTO\MovieGenreDTO;
use FOPG\Component\UtilsBundle\Collection\Collection;

trait ConverterTrait {

  public static function convert_array_to_entity(array $data): MovieGenreDTO {
    throw new \Exception('@todo à implémenter');
  }
  
  public static function convert_array_to_collection(array $data): Collection {
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
          $entity = new MovieGenreDTO();
          $entity->setId($genre['id']);
          $entity->setName($genre['name']);
          return $entity;
        }
      );
      /** Tri rapide */
      $collection->heapSort();
    }
    return $collection;
  }
}
