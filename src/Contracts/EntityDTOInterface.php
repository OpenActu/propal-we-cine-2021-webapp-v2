<?php

namespace App\Contracts;

interface EntityDTOInterface {
  public function getId(): ?int;
  public function getName(): ?string;
}
