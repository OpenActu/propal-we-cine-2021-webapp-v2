<?php

namespace App\Controller\Movie;

use App\Entity\DTO\MovieDTO;
use App\Service\TMDB\Manager\MovieManager;
use App\Utils\CollectionUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie')]
class SearchCollection extends AbstractController
{
    public function __construct(
      private MovieManager $mm
    ) {
    }

    #[Route('/search/', name: 'api_movie_GET_search_collection', methods:["GET"],options: ['expose' => true])]
    public function __invoke(Request $request): Response
    {
        $query = $request->get('term','');
        $this->mm->setLocale($request->getLocale());
        /** @var Collection $movies */
        $movies=$this->mm->search(query: $query,page: 1);
        return new JsonResponse(CollectionUtils::serialize_to_array($movies));
    }
}
