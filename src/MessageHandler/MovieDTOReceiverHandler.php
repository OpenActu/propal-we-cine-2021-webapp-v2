<?php 
namespace App\MessageHandler;

use App\Utils\DesignPattern\Builder\BuilderManager;
use App\Builder\MovieBuilder;
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
        $bm = new BuilderManager();
        $builder = new MovieBuilder(movieDTO: $movieDTO,em: $this->em);
        $movie = $bm->make($builder);
        $this->em->flush();
    }
}