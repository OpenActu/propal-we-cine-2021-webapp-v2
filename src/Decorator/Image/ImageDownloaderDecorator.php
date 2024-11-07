<?php 
namespace App\Decorator\Image; 

use App\Service\Minio\FileSystem as FSO;
use App\Contracts\DesignPattern\DecoratorInterface;
use App\Utils\DesignPattern\Decorator\AbstractDecorator;
use App\Service\TMDB\Manager\ImageManager;

class ImageDownloaderDecorator extends AbstractDecorator implements DecoratorInterface {
    public function __construct(
        private ImageManager $im,
        private FSO $fso
    ) {
    }

    public function download(string $filename, string $format, string $locale): ?string {
        $image = $this->findOneBy(['originFilename' => $filename, 'format' => $format, 'locale' => $locale]);
        if(null === $image) {
            $content = $this
                ->im
                ->setLocale($locale)
                ->download(filename: $filename,format: $format)
            ;
        }
        else {
            $path = $this->build_path(format: $format, filename: $filename, locale: $locale);
            $content = $this->fso->read($path);
        }
        return $content;
    }
}