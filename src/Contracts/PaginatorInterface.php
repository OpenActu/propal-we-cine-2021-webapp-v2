<?php

namespace App\Contracts;

use FOPG\Component\UtilsBundle\Collection\Collection;

interface PaginatorInterface {
  const DEFAULT_OFFSET=0;
  const DEFAULT_LIMIT=10;

  public function findAll(int $offset=self::DEFAULT_OFFSET, int $limit=self::DEFAULT_LIMIT): Collection;
}
