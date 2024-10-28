<?php

namespace App\Controller;

use App\Service\TMDB\Manager\{MovieGenreManager,MovieManager};
use FOPG\Component\UtilsBundle\Collection\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie-genre')]
class MovieGenreController extends AbstractController
{
    public function __construct(
      private MovieGenreManager $mgm,
      private MovieManager $mm
    ) {

    }
    #[Route('/', name: 'movie_genre_index', methods:["GET"])]
    #[Route('/{id}', name: 'movie_genre_list_by_category', requirements:["id"=>"\d+"], methods:["GET"])]
    public function index(Request $request, ?int $id=null): Response
    {
        return $this->render('movie/index.html.twig', [
            'movieGenres' => $this->mgm->setLocale($request->getLocale())->findAll(),
            'movies' => $this->mm->setLocale($request->getLocale())->findBy(params: (null !== $id)?['with_genres' => $id]:[], sortBy: ['popularity' => 'desc'], page: 1),
            'totalPages' => $this->mm->getTotalPages(),
            'totalResults' => $this->mm->getTotalResults(),
            'highlights' => $this->mm->setLocale($request->getLocale())->findBy(sortBy: ['popularity' => 'desc'], page: 1, limit: 6),
        ]);
    }
}
