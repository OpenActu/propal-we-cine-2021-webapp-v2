<?php

namespace App\Controller\Movie;

use App\Entity\DTO\MovieDTO;
use App\Service\TMDB\Manager\MovieManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\MovieDTOReceiver;

#[Route('/api/movie_dto')]
class GetItem extends AbstractController
{
    public function __construct(
      private MessageBusInterface $bus,
      private MovieManager $mm
    ) {
    }

    #[Route('/{id}', name: 'api_movie_dto_GET_item', requirements:["id"=>"\d+"], methods:["GET"],options: ['expose' => true])]
    public function __invoke(Request $request, ?int $id=null): Response
    {  
      /** @var ?MovieDTO $movie */
      $movie= $this->mm->setLocale($request->getLocale())->find($id);
      /** @var array $data */
      $data=[];
      if($movie) {
        $data = $movie->serializeToArray();
        $this->bus->dispatch(new MovieDTOReceiver($data));
      }
      return new JsonResponse($data);
    }
}
