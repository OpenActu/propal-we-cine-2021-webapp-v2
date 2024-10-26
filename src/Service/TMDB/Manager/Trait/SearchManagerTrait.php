<?php

namespace App\Service\TMDB\Manager\Trait;

use App\Contracts\SearchInterface;

trait SearchManagerTrait {
  private int $page=SearchInterface::DEFAULT_PAGE;
  private int $totalPages=0;
  private int $totalResults=0;

  public function setTotalPages(int $totalPages): static { $this->totalPages=$totalPages; return $this; }
  public function getTotalPages(): int { return $this->totalPages; }
  public function setTotalResults(int $totalResults): static { $this->totalResults=$totalResults; return $this; }
  public function getTotalResults(): int { return $this->totalResults; }
}
