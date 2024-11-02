<?php

namespace App\Controller;

use App\Service\TMDB\Manager\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Message\ImageReceiver;
use Symfony\Component\Messenger\MessageBusInterface;

#[Route('/image')]
class ImageController extends AbstractController {

  public function __construct(private ImageManager $im, private MessageBusInterface $bus) { }

  #[Route('/format.{format}/filename.{filename}',name: 'image_get', options: ['expose' => true])]
  public function index(Request $request, ?string $filename='', ?string $format=''): ?Response {
    /** @var ?string $content */
    $content = $this
      ->im
      ->setLocale($request->getLocale())
      ->download(filename: $filename,format: $format)
    ;
    if(!empty($content)) 
      $this->bus->dispatch(new ImageReceiver(format: $format, filename: $filename, content: $content));
    return new Response(
        $content,
        200,
        [
          'Content-Type' => 'application/jpg',
          'Content-Disposition' => 'inline; filename="file.jpg"',
        ]
      );
  }
}
