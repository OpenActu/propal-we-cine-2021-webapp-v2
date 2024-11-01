<?php 
namespace App\Entity\Trait\MovieGenre;

use App\Entity\MovieGenre;
use App\Entity\DTO\MovieGenreDTO;
use App\Contracts\{EntityDTOInterface, EntityInterface};

trait ReceiverDTOTrait {

    public function isMappedBy(): string 
    {
        return MovieGenreDTO::class;
    }

    public function populateFromArray(array $obj): EntityInterface {
        if(!empty($obj['id']))
            $this->setTmdbId($obj['id']);
        if(!empty($obj['name']))
            $this->setName($obj['name']??null);
        return $this;
    }

}