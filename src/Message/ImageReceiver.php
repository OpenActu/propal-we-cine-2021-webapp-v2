<?php 
namespace App\Message;

use App\Contracts\DesignPattern\PrototypeProducerInterface;
use App\Contracts\DesignPattern\PrototypeConsumerInterface;
use App\Contracts\Entity\ImageInterface;

class ImageReceiver implements PrototypeProducerInterface {
    public static function clone(PrototypeConsumerInterface $consumer, PrototypeProducerInterface $producer): void {
        $consumer->setFilename($producer->getFilename());
        $consumer->setFormat($producer->getFormat());
        $consumer->setLocale($producer->getLocale());
    }
    public function __construct(private string $filename, private string $format, private string $locale) { }
    public function getFilename(): string { return $this->filename; }
    public function getFormat(): string { return $this->format; }
    public function getLocale(): string { return $this->locale; }
}