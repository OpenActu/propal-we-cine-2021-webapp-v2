<?php

namespace App\Entity\DTO;

use App\Contracts\EntityDTOInterface;

class MovieGenreDTO implements EntityDTOInterface {
  use BasisTrait;

  public function __construct(?int $id=null,?string $name=null) {
    if(!empty($id))
      $this->setId($id);
    if(!empty($name))
      $this->setName($name);
  }
}
