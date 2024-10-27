<?php

namespace App\Controller;

use App\Entity\DTO\MovieDTO;
use App\Service\TMDB\Manager\MovieManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie')]
class MovieController extends AbstractController
{
    public function __construct(
      private MovieManager $mm
    ) {
    }

    #[Route('/{id}', name: 'api_movie_GET_item', requirements:["id"=>"\d+"], methods:["GET"],options: ['expose' => true])]
    public function jsonIndex(Request $request, ?int $id=null): Response
    {
        $this->mm->setLocale($request->getLocale());
        /** @var ?MovieDTO $movie */
        $movie=$this->mm->find($id);
        return new JsonResponse($movie->serializeToArray());
    }
}
