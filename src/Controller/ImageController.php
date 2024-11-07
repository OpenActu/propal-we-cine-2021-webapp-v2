<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Decorator\Image\{ImageDownloaderDecorator, ImageDispatcherDecorator};

#[Route('/image')]
class ImageController extends AbstractController {

  public function __construct(
    private ImageDownloaderDecorator $imageDownloaderDecorator,
    private ImageDispatcherDecorator $imageDispatcherDecorator,
    private ImageRepository $ir
  ) { }

  #[Route('/format.{format}/filename.{filename}',name: 'image_get', options: ['expose' => true])]
  public function index(Request $request, ?string $filename='', ?string $format=''): ?Response {

    $locale=$request->getLocale();
    $this->imageDownloaderDecorator->decorate($this->ir);
    $this->imageDispatcherDecorator->decorate($this->imageDownloaderDecorator);

    $content = $this->imageDispatcherDecorator->download(filename: $filename, locale: $locale, format: $format);

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
