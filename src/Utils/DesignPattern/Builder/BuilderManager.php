<?php 
namespace App\Utils\DesignPattern\Builder;

use App\Contracts\DesignPattern\{BuilderInterface, BuilderInstanceInterface};

class BuilderManager {
    public function make(BuilderInterface $builder): ?BuilderInstanceInterface {
        return $builder->getInstance();
    }
}