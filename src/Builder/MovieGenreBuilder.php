<?php 
namespace App\Builder;

use App\Entity\MovieGenre;
use Doctrine\ORM\EntityManagerInterface; 

class MovieGenreBuilder extends AbstractBuilder {
    public function __construct(array $movieGenreDTO, EntityManagerInterface $em, string $locale) {
        $mgr = $em->getRepository(MovieGenre::class);
        $movieGenre = $mgr->findOneBy(['tmdbId' => $movieGenreDTO['id']]);
        if(null===$movieGenre) {
            $movieGenre = new MovieGenre();
            $em->persist($movieGenre);
        }
        $movieGenre->populateFromArray($movieGenreDTO);
        $this->setInstance($movieGenre);
    }
}