<?php 
namespace App\Contracts\Entity;

use App\Contracts\DesignPattern\PrototypeConsumerInterface;

interface ImageInterface extends PrototypeConsumerInterface {
    public function getFilename(): ?string;
    public function setFilename(string $filename): static;
    public function getFormat(): ?string;
    public function setFormat(string $format): static;
    public function getLocale(): string;
    public function setLocale(string $locale): static;
}