<?php 
namespace App\MessageHandler;

use App\Service\TMDB\Manager\ImageManager;
use App\Entity\Image;
use App\Message\ImageReceiver; 
use App\Repository\ImageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Minio\FileSystem as FSO; 

#[AsMessageHandler]
class ImageReceiverHandler {

    public function __construct(
        private ImageManager $im,
        private EntityManagerInterface $em,
        private ImageRepository $imgr,
        private FSO $fso
    ) { }

    public function __invoke(ImageReceiver $ir) {
        $image = $this->imgr->findOneBy(['originFilename' => $ir->getFilename(),'format' => $ir->getFormat(),'locale' => $ir->getLocale()]);
        if(null === $image) {
            /** @var ?string $content */
            $content = $this
                ->im
                ->setLocale($ir->getLocale())
                ->download(filename: $ir->getFilename(),format: $ir->getFormat())
            ;

            $path = $this->imgr->build_path(format: $ir->getFormat(), filename: $ir->getFilename(),locale: $ir->getLocale());
            $this->fso->writeContent($path, $content);
            $image = new Image();
            ImageReceiver::clone($image,$ir);
            $image
                ->setOriginFilename($ir->getFilename())
                ->setPath($path)
            ;
            $this->em->persist($image);
            $this->em->flush();
        }
    }
}