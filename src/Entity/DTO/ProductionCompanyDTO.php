<?php

namespace App\Entity\DTO;

use App\Entity\Trait\ProductionCompany\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};

class ProductionCompanyDTO extends AbstractEntityDTO {

  use IdentifierTrait;
  use PathTrait;
  use SerializerTrait;

  private ?CountryDTO $originCountry=null;

  public function __construct(
    ?string $id=null,
    ?string $name=null,
    ?string $logoPath=null
  ) {
    $this->setId($id);
    $this->setName($name);
    $this->setLogoPath($logoPath);
  }

  public function setOriginCountry(CountryDTO $country): static { $this->originCountry=$country; return $this; }
  public function getOriginCountry(): ?CountryDTO { return $this->originCountry; }
}
