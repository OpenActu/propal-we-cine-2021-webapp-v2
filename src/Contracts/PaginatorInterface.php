<?php

namespace App\Contracts;

interface PaginatorInterface {
  const DEFAULT_OFFSET=0;
  const DEFAULT_LIMIT=10;

  public function findAll(int $offset=self::DEFAULT_OFFSET, int $limit=self::DEFAULT_LIMIT): array;
}
