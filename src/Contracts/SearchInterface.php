<?php

namespace App\Contracts;

use FOPG\Component\UtilsBundle\Collection\Collection;

interface SearchInterface {
  
  const DEFAULT_OFFSET=0;
  const DEFAULT_LIMIT=10;

  public function findAll(int $offset=self::DEFAULT_OFFSET, int $limit=self::DEFAULT_LIMIT): Collection;
  public function findBy(array $params=[], int $offset=self::DEFAULT_OFFSET, int $limit=self::DEFAULT_LIMIT): Collection;
}
