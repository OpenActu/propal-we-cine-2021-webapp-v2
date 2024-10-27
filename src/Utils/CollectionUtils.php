<?php

namespace App\Utils;

use App\Contracts\SerializerInterface;
use FOPG\Component\UtilsBundle\Collection\Collection;

class CollectionUtils {
  public static function serialize_to_array(Collection $collection): array {
    $output=[];
    /** @var SerializerInterface $item */
    foreach($collection as $item)
      $output[]=$item->serializeToArray();
    return $output;
  }
}
