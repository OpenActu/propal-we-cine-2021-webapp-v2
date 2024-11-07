<?php 
namespace App\Contracts\DesignPattern;

interface PrototypeProducerInterface {
    public static function clone(PrototypeConsumerInterface $consumer, PrototypeProducerInterface $producer): void;
}