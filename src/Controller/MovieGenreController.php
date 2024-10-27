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
        $this->mm->setLocale($request->getLocale());
        $this->mgm->setLocale($request->getLocale());
        /** @var array $params */
        $params=[];
        if(null !== $id)
          $params=['with_genres' => $id];
        /** @var Collection $movies */
        $movies=$this->mm->findBy(params: $params, sortBy: ['popularity' => 'desc'], page: 1);
        $highlights=$this->mm->findBy(sortBy: ['popularity' => 'desc'], page: 1, limit: 6);
        /** @var int $totalPages */
        $totalPages=$this->mm->getTotalPages();
        /** @var int $totalResults */
        $totalResults=$this->mm->getTotalResults();
        /** @var Collection $movieGenres */
        $movieGenres=$this->mgm->findAll();
        return $this->render('movie/index.html.twig', [
            'movieGenres' => $movieGenres,
            'movies' => $movies,
            'totalPages' => $totalPages,
            'totalResults' => $totalResults,
            'highlights' => $highlights,
        ]);
    }
}
