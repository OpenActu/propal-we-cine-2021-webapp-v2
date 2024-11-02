<?php 
namespace App\MessageHandler;

use App\Entity\Image;
use App\Message\ImageReceiver; 
use App\Repository\ImageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Minio\FileSystem as FSO; 

#[AsMessageHandler]
class ImageReceiverHandler {

    public function __construct(
        private EntityManagerInterface $em,
        private ImageRepository $imgr,
        private FSO $fso
    ) { }

    public function __invoke(ImageReceiver $ir) {
        $image = $this->imgr->findOneBy(['originFilename' => $ir->getFilename(),'format' => $ir->getFormat()]);
        if(null === $image) {
            
            $path = $this->imgr->build_path(format: $ir->getFormat(), filename: $ir->getFilename());
            $this->fso->writeContent($path, $ir->getContent());
            $image = new Image();
            $image
                ->setOriginFilename($ir->getFilename())
                ->setFilename($ir->getFilename())
                ->setFormat($ir->getFormat())
                ->setPath($path)
            ;
            $this->em->persist($image);
            $this->em->flush();
        }
    }
}