<?php

namespace App\Controller;

use App\Service\TMDB\Manager\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image')]
class ImageController extends AbstractController {

  public function __construct(private ImageManager $im) { }

  #[Route('/format.{format}/filename.{filename}',name: 'image_get', options: ['expose' => true])]
  public function index(Request $request, ?string $filename='', ?string $format=''): ?Response {
    return new Response(
        $this->im->setLocale($request->getLocale())->download(filename: $filename,format: $format),
        200,
        [
          'Content-Type' => 'application/jpg',
          'Content-Disposition' => 'inline; filename="file.jpg"',
        ]
      );
  }
}
