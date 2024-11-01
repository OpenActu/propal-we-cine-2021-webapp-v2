<?php 
namespace App\Entity\Trait\Country;

use App\Entity\Country;
use App\Entity\DTO\CountryDTO;
use App\Contracts\{EntityDTOInterface, EntityInterface};

trait ReceiverDTOTrait {

    public function isMappedBy(): string 
    {
        return CountryDTO::class;
    }

    public function populateFromArray(array $obj): EntityInterface {
        $this->setCode($obj['code']);
        $this->setName($obj['name']??null);
        return $this;
    }

}