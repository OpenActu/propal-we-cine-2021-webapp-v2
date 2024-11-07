<?php 
namespace App\Utils\DesignPattern\Decorator;

use App\Contracts\DesignPattern\DecoratorInterface;

abstract class AbstractDecorator {

    private ?DecoratorInterface $parent=null;

    public function decorate(?DecoratorInterface $parent): static { $this->parent = $parent; return $this; }
    public function __call($method, $args) { return $this->parent->$method(...$args); }
}