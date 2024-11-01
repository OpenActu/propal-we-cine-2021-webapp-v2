<?php 
namespace App\Message;

class MovieDTOReceiver {
    public function __construct(private array $movieDTO) { }
    public function getMovieDTO(): array { return $this->movieDTO; }
}