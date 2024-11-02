<?php 
namespace App\Contracts;

interface DocumentInterface {
    public function getFilename(): ?string;
    public function getOriginFilename(): ?string;
    public function getSize(): ?string;
}