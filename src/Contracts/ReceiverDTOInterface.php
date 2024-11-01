<?php 
namespace App\Contracts;

interface ReceiverDTOInterface {
    public function isMappedBy(): string;
    public function populateFromArray(array $obj): EntityInterface;
}