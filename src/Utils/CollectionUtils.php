<?php

namespace App\Utils;

use App\Contracts\SerializerInterface;
use App\Utils\Collection\Collection;

class CollectionUtils {
  public static function serialize_to_array(Collection $collection): array {
    $output=[];
    /** @var SerializerInterface $item */
    foreach($collection as $item)
      $output[]=$item->serializeToArray();
    return $output;
  }
}
