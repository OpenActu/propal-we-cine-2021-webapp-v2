<?php

namespace App\Entity\DTO\Trait;

trait ReferenceTrait {
  private ?string $code=null;
  private ?string $name=null;
  public function setCode(?string $code): static { $this->code=$code; return $this; }
  public function getCode(): ?string { return $this->code; }
  public function setName(?string $name): static { $this->name=$name; return $this; }
  public function getName(): ?string { return $this->name; }
  
}
