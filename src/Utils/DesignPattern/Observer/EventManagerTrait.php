<?php 
namespace App\Utils\DesignPattern\Observer;

use pp\Contracts\DesignPattern\EventListenerInterface;

trait EventManagerTrait {
    private array $eventListeners=[];

    public function subscribe(string $eventType, EventListenerInterface $event): static {
        if(empty($this->eventListeners[$eventType]))
            $this->eventListeners[$eventType][]=$event;
        return $this;
    }

    public function notify(string $eventType, mixed $data): void {
        $listeners=$this->eventListeners[$eventType]??[];
        foreach($listeners as $listener) 
            $listener->apply($data);
    }
} 