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
        if(!empty($obj['code']))
            $this->setCode($obj['code']);
        if(!empty($obj['name']))
            $this->setName($obj['name']??null);
        if(!empty($obj['englishName']))
            $this->setEnglishName($obj['englishName']??null);
        if(!empty($obj['locale']))
            $this->setLocale($obj['locale']);
        return $this;
    }

}