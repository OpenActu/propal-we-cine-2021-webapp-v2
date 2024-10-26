<?php

namespace App\Service\TMDB\Manager;

use App\Contracts\LocalizationInterface;

trait LocalizationManagerTrait {
  private string $locale=LocalizationInterface::DEFAULT_LOCALE;
  public function setLocale(string $locale): static { $this->locale=$locale; return $this->locale; }
  public function getLocale(): string { return $this->locale; }
}
