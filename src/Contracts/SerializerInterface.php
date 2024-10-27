<?php

namespace App\Contracts;

interface SerializerInterface {
  public function serializeToArray(): array;
}
