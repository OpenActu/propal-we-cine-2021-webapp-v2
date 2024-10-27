<?php

namespace App\Contracts;

use FOPG\Component\UtilsBundle\Collection\Collection;

interface ConverterInterface {
  public static function convert_array_to_collection(array $data,int $limit): Collection;
  public static function convert_array_to_entity(array $data): EntityDTOInterface;
}