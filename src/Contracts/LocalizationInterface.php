<?php

namespace App\Contracts;

interface LocalizationInterface {

  const DEFAULT_LOCALE='fr';

  public function setLocale(string $locale): static;
  public function getLocale(): string;
}
