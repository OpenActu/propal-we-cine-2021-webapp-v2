<?php 
namespace App\Builder;

use App\Entity\Movie;
use App\Contracts\DesignPattern\{BuilderInterface,BuilderInstanceInterface};
use App\Repository\{MovieRepository, LanguageRepository};
use Doctrine\ORM\EntityManagerInterface;

class MovieBuilder extends AbstractBuilder {
    
    public static function build_language(array $movieDTO, EntityManagerInterface $em, string $locale): ?BuilderInstanceInterface {
        if(!empty($movieDTO['originalLanguage']) && is_array($movieDTO['originalLanguage'])) {
            $languageDTO = $movieDTO['originalLanguage'];
            $languageBuilder = new LanguageBuilder(languageDTO: $languageDTO, em: $em, locale: $locale);
            return $languageBuilder->getInstance();
        }
        return null;
    }

    public static function build_movie_genre(array $movieGenreDTO, EntityManagerInterface $em, string $locale): ?BuilderInstanceInterface {
        $movieGenreBuilder = new MovieGenreBuilder(movieGenreDTO: $movieGenreDTO, em: $em, locale: $locale);
        return $movieGenreBuilder->getInstance();    
    }

    public static function build_country(array $countryDTO, EntityManagerInterface $em): ?BuilderInstanceInterface {
        $countryBuilder = new CountryBuilder(countryDTO: $countryDTO, em: $em);
        return $countryBuilder->getInstance();        
    }

    public function __construct(array $movieDTO, EntityManagerInterface $em) {
        /** @var MovieRepository $movieRepository */
        $movieRepository = $em->getRepository(Movie::class);
        if(empty($movieDTO['id']))
            return;
        $movie = $movieRepository->findOneBy(['tmdbId' => $movieDTO['id']]);
        if(null === $movie) {
            $movie = new Movie();
            $em->persist($movie);
        }
        $movie->populateFromArray($movieDTO);

        if(null!==($language=self::build_language(movieDTO: $movieDTO, em: $em, locale: $movieDTO['locale'])))
            $movie->setOriginalLanguage($language);  
        
        if(!empty($movieDTO['genres']) && is_array($movieDTO['genres']) && count($movieDTO['genres'])) {
            $movieGenresDTO = $movieDTO['genres'];
            foreach($movieGenresDTO as $movieGenreDTO)
                if(null!==($movieGenre=self::build_movie_genre(movieGenreDTO: $movieGenreDTO, em: $em, locale: $movieDTO['locale'])))
                    $movie->addGenre($movieGenre);
        }

        if(!empty($movieDTO['originCountries']) && is_array($movieDTO['originCountries']) && count($movieDTO['originCountries'])) {
            $originCountriesDTO = $movieDTO['originCountries'];
            foreach($originCountriesDTO as $originCountryDTO)
                if(null!==($country=self::build_country(countryDTO: $originCountryDTO, em: $em)))
                    $movie->addOriginCountry($country);
        }
        $this->setInstance($movie);
    }
}