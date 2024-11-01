<?php 
namespace App\Entity\Trait\Language;

use App\Entity\Language;
use App\Entity\DTO\LanguageDTO;
use App\Contracts\{EntityDTOInterface, EntityInterface};

trait ReceiverDTOTrait {

    public function isMappedBy(): string 
    {
        return LanguageDTO::class;
    }

    public function populateFromArray(array $obj): EntityInterface {
        $this->setCode($obj['code']);
        $this->setName($obj['name']??null);
        $this->setEnglishName($obj['englishName']??null);
        return $this;
    }

}