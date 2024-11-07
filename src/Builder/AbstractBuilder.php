<?php 
namespace App\Builder; 

use App\Contracts\DesignPattern\{BuilderInterface,BuilderInstanceInterface};

abstract class AbstractBuilder implements BuilderInterface {
    private ?BuilderInstanceInterface $instance=null;
    public function setInstance(BuilderInstanceInterface $instance): static { $this->instance=$instance; return $this; }
    public function getInstance(): ?BuilderInstanceInterface { return $this->instance; }
}