<?php

namespace App\Repository;

use App\Contracts\DesignPattern\DecoratorInterface;
use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Contracts\LocalizationInterface;

/**
 * @extends ServiceEntityRepository<Image>
 */
class ImageRepository extends ServiceEntityRepository implements DecoratorInterface
{
    const IMAGE_PATH='images';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function start(?DecoratorInterface $parent=null) { }
    public static function build_path(string $locale=LocalizationInterface::DEFAULT_LOCALE, string $format, string $filename): string { return self::IMAGE_PATH.'/'.$locale.'/'.$format.'/'.$filename; }
}
