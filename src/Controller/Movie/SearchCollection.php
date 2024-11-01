<?php

namespace App\Controller\Movie;

use App\Entity\DTO\MovieDTO;
use App\Service\TMDB\Manager\MovieManager;
use App\Utils\Collection\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/movie_dto')]
class SearchCollection extends AbstractController
{
    public function __construct(
      private MovieManager $mm
    ) {
    }

    #[Route('/search/', name: 'api_movie_dto_GET_search_collection', methods:["GET"],options: ['expose' => true])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse($this->mm->setLocale($request->getLocale())->search(query: $request->get('term',''),page: 1)->serializeToArray());
    }
}
