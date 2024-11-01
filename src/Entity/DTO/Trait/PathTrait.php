<?php

namespace App\Entity\DTO\Trait;

use App\Contracts\DocumentInterface;

trait PathTrait {
  private ?DocumentInterface $poster=null;
  private ?DocumentInterface $backdrop=null;
  private ?DocumentInterface $logo=null;
  public function setLogo(DocumentInterface $document): static { $this->logo = $document; return $this; }
  public function getLogo(): ?DocumentInterface { return $this->logo; }
  public function setPoster(DocumentInterface $poster): static { $this->poster = $poster; return $this; }
  public function getPoster(): ?DocumentInterface { return $this->poster; }
  public function setBackdrop(DocumentInterface $backdrop): static { $this->backdrop = $backdrop; return $this; }
  public function getBackdrop(): ?DocumentInterface { return $this->backdrop; }
}
