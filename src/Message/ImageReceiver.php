<?php 
namespace App\Message;

class ImageReceiver {
    public function __construct(private string $filename, private string $format, private string $locale) { }
    public function getFilename(): string { return $this->filename; }
    public function getFormat(): string { return $this->format; }
    public function getLocale(): string { return $this->locale; }
}