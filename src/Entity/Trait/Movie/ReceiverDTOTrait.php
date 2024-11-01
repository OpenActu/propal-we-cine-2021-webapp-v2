<?php 
namespace App\Entity\Trait\Movie;

use App\Entity\Movie;
use App\Entity\DTO\MovieDTO;
use App\Contracts\{EntityDTOInterface, EntityInterface};

trait ReceiverDTOTrait {

    public function isMappedBy(): string 
    {
        return MovieDTO::class;
    }

    public function populateFromArray(array $obj): EntityInterface {
        $mapper = [
            'setName' => 'title',
            'setTitle' => 'title',
            'setTmdbId' => 'id',
            'setAdult' => 'adult',
            'setOriginalTitle' => 'originalTitle',
            'setOverview' => 'overview',
            'setPopularity' => 'popularity',
            'setVoteAverage' => 'voteAverage',
            'setVoteCount' => 'voteCount',
            'setImdbId' => 'imdbId',
            'setStatus' => 'status',
            'setTagline' => 'tagline',
            'setVideo' => 'video',
        ];
        foreach($mapper as $method => $parameter) 
            if(isset($obj[$parameter]) && (null!==$obj[$parameter]))
                $this->$method($obj[$parameter]);
            
        if(!empty($obj['releaseDate']))
            $this->setReleaseDate(new \DateTime($obj['releaseDate']));
        if(!empty($obj['budget']))
            $this->setBudget(preg_replace("/[ ]+/","",$obj['budget']));
        if(!empty($obj['revenue']))
            $this->setRevenue(preg_replace("/[ ]+/","",$obj['revenue']));
        return $this;
    }

}