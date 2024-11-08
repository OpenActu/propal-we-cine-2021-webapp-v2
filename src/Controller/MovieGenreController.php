<?php

namespace App\Controller;

use App\Message\MovieDTOReceiver;
use App\Entity\DTO\MovieDTO;
use App\Utils\Collection\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Contracts\Manager\{MovieManagerInterface,MovieGenreManagerInterface};
#[Route('/movie-genre')]
class MovieGenreController extends AbstractController
{
    public function __construct(
      private MessageBusInterface $bus,
      private MovieGenreManagerInterface $mgm,
      private MovieManagerInterface $mm
    ) {
    }
    #[Route('/', name: 'movie_genre_index', methods:["GET"])]
    #[Route('/{id}', name: 'movie_genre_list_by_category', requirements:["id"=>"\d+"], methods:["GET"])]
    public function index(Request $request, ?int $id=null): Response
    {
        /** @var Collection $movies */
        $movies=$this->mm->setLocale($request->getLocale())->findBy(params: (null !== $id)?['with_genres' => $id]:[], sortBy: ['popularity' => 'desc'], page: 1);
        /** @var MovieDTO $movieDTO */
        foreach($movies as $movieDTO) {
            //$data = $movieDTO->serializeToArray();
            //$this->bus->dispatch(new MovieDTOReceiver($data));
        }
        return $this->render('movie/index.html.twig', [
            'movieGenres' => $this->mgm->setLocale($request->getLocale())->findAll(),
            'movies' => $movies,
            'totalPages' => $this->mm->getTotalPages(),
            'totalResults' => $this->mm->getTotalResults(),
            'highlights' => $this->mm->setLocale($request->getLocale())->findBy(sortBy: ['popularity' => 'desc'], page: 1, limit: 6),
        ]);
    }
}
