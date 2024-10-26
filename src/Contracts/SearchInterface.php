<?php

namespace App\Contracts;

use FOPG\Component\UtilsBundle\Collection\Collection;

interface SearchInterface {

  const DEFAULT_PAGE=1;
  const DEFAULT_OFFSET=0;
  const DEFAULT_LIMIT=20;
  const SORT_ASC='asc';
  const SORT_DESC='desc';

  public function findAll(int $offset=self::DEFAULT_OFFSET, int $limit=self::DEFAULT_LIMIT): Collection;
  public function findBy(array $params=[], array $sortBy=[], int $offset=self::DEFAULT_OFFSET, int $limit=self::DEFAULT_LIMIT): Collection;
}
