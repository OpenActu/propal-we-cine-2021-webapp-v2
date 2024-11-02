<?php 
namespace App\Message;

class ImageReceiver {
    public function __construct(private string $filename, private string $format, private string $content) { }
    public function getFilename(): string { return $this->filename; }
    public function getContent(): string { return $this->content; }
    public function getFormat(): string { return $this->format; }
}