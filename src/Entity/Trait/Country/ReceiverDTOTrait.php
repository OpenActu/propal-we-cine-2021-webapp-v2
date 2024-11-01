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
        if(!empty($obj['code']))
            $this->setCode($obj['code']);
        if(!empty($obj['name']))
            $this->setName($obj['name']??null);
        return $this;
    }

}