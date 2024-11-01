<?php 
namespace App\Contracts;

interface DocumentInterface {
    public function getFilename(): ?string;
    public function getOriginalFilename(): ?string;
    public function getSize(): ?string;
}