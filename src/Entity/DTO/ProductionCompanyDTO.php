<?php

namespace App\Entity\DTO;

use App\Contracts\Entity\ProductionCompanyInterface;
use App\Entity\Trait\ProductionCompany\SerializerTrait;
use App\Entity\DTO\Trait\{IdentifierTrait,PathTrait};

class ProductionCompanyDTO extends AbstractEntityDTO implements ProductionCompanyInterface {

  use IdentifierTrait;
  use PathTrait;
  use SerializerTrait;

  private ?CountryDTO $originCountry=null;

  protected function __construct(
    ?string $id=null,
    ?string $name=null,
    ?string $logoPath=null
  ) {
    $this->setId($id);
    $this->setName($name);
    if($logoPath)
      $this->setLogo(ImageDTO::getInstance(filename: $logoPath));
  }

  public function setOriginCountry(CountryDTO $country): static { $this->originCountry=$country; return $this; }
  public function getOriginCountry(): ?CountryDTO { return $this->originCountry; }
}
