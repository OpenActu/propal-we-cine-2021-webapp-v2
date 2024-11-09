<?php 
namespace App\Contracts\DesignPattern;

interface EventListenerInterface {
    public function apply(mixed $data): void;
}