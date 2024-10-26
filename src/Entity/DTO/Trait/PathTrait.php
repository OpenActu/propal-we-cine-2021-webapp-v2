<?php

namespace App\Entity\DTO\Trait;

trait PathTrait {
  private ?string $posterPath=null;
  private ?string $backdropPath=null;
  private ?string $logoPath=null;
  public function setLogoPath(?string $logoPath): static { $this->logoPath = $logoPath; return $this; }
  public function getLogoPath(): ?string { return $this->logoPath; }
  public function setPosterPath(?string $posterPath): static { $this->posterPath = $posterPath; return $this; }
  public function getPosterPath(): ?string { return $this->posterPath; }
  public function setBackdropPath(?string $backdropPath): static { $this->backdropPath = $backdropPath; return $this; }
  public function getBackdropPath(): ?string { return $this->backdropPath; }

}
