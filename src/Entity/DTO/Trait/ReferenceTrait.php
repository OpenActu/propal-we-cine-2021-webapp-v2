<?php

namespace App\Entity\DTO\Trait;

trait ReferenceTrait {
  private ?string $code=null;
  public function setCode(?string $code): static { $this->code=$code; return $this; }
  public function getCode(): ?string { return $this->code; }
}
