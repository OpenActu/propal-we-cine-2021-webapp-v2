<?php

namespace App\Entity\DTO\Trait;

use Symfony\Component\Serializer\Annotation\Groups;

trait IdentifierTrait {

  #[Groups(['global_dto_read'])]
  private ?int $id=null;
  #[Groups(['global_dto_read'])]
  private ?string $name=null;
  
  public function getId(): ?int { return $this->id; }
  public function setId(int $id): static { $this->id=$id;return $this; }
  public function getName(): ?string { return $this->name; }
  public function setName(?string $name): static { $this->name = $name; return $this; }
}
