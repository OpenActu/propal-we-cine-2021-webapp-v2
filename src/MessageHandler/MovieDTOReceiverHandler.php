<?php 
namespace App\MessageHandler;

use App\Entity\{Country,Language,MovieGenre,Movie};
use App\Message\MovieDTOReceiver;
use App\Repository\{CountryRepository,LanguageRepository,MovieGenreRepository,MovieRepository};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MovieDTOReceiverHandler {
    
    public function __construct(
        private EntityManagerInterface $em,
        private CountryRepository $cr,
        private LanguageRepository $lr,
        private MovieGenreRepository $mgr,
        private MovieRepository $mr
    ) { }

    public function __invoke(MovieDTOReceiver $movieDTOReceiver) {
        /** @var array $movieDTO */
        $movieDTO = $movieDTOReceiver->getMovieDTO();
        if(empty($movieDTO['id']))
            return;

        $movie = $this->mr->findOneBy(['tmdbId' => $movieDTO['id']]);
        if(null === $movie) {
            $movie = new Movie();
            $this->em->persist($movie);
        }
        $movie->populateFromArray($movieDTO);

        if(!empty($movieDTO['originalLanguage']) && is_array($movieDTO['originalLanguage'])) {
            $languageDTO = $movieDTO['originalLanguage'];
            $language = $this->lr->findOneBy(['code' => $languageDTO['code']]);
            if(null===$language) {
                $language = new Language();
                $this->em->persist($language);
            }  
            $language->populateFromArray($languageDTO);
            $movie->setOriginalLanguage($language);    
        }
        if(!empty($movieDTO['movieGenres']) && is_array($movieDTO['movieGenres']) && count($movieDTO['movieGenres'])) {
            $movieGenresDTO = $movieDTO['movieGenres'];
            foreach($movieGenresDTO as $movieGenreDTO) {
                $movieGenre = $this->mgr->findOneBy(['tmdbId' => $movieGenreDTO['id']]);
                if(null===$movieGenre) {
                    $movieGenre = new MovieGenre();
                    $this->em->persist($movieGenre);
                }
                $movieGenre->populateFromArray($movieGenreDTO);
                $movie->addGenre($movieGenre);
            }
        }

        if(!empty($movieDTO['originCountries']) && is_array($movieDTO['originCountries']) && count($movieDTO['originCountries'])) {
            $originCountriesDTO = $movieDTO['originCountries'];
            foreach($originCountriesDTO as $originCountryDTO) {
                $country = $this->cr->findOneBy(['code' => $originCountryDTO['code']]);
                if(null === $country) {
                    $country = new Country();
                    $this->em->persist($country);
                }
                $country->populateFromArray($originCountryDTO);
                $movie->addOriginCountry($country);
            }
        }

        $this->em->flush();
    }
}