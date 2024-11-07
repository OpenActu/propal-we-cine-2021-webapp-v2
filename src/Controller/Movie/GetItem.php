<?php

namespace App\Controller\Movie;

use App\Proxy\ProxyMovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/movie_dto')]
class GetItem extends AbstractController
{
    public function __construct(
      private ProxyMovieRepository $mr
    ) {
    }

    #[Route('/{id}', name: 'api_movie_dto_GET_item', requirements:["id"=>"\d+"], methods:["GET"],options: ['expose' => true])]
    public function __invoke(Request $request, ?int $id=null): Response
    {
      $this
        ->mr
        ->setId($id)
        ->setLocale($request->getLocale())
      ;
      /** @var array $data */
      $data = $this->mr->serializeToArray();
      return new JsonResponse($data);
    }
}
