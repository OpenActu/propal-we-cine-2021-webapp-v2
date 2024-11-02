<?php 
namespace App\Service\Cache;

use Symfony\Contracts\Cache\CacheInterface;
use App\Utils\String\StringFacility;

class CacheManager {
    
    private array $parameters=[];
    
    public function __construct(private CacheInterface $cache) {}
    
    public function init(array $parameters): static { $this->parameters=$parameters; return $this; }
    
    public function exists(): bool {
        $key = $this->getKey();
        return $this->cache->hasItem($key);
    }

    public function get(): ?array {
        $obj = $this->cache->getItem($this->getKey());
        return $obj->get();
        
    }

    public function save(array $data): bool {
        $obj = $this->cache->getItem($this->getKey());
        $obj->set($data);
        return $this->cache->save($obj);
    }

    public function delete(): bool {
        return $this->cache->deleteItem($this->getKey());
    }
    
    private function getKey():?string { 
        if(count($this->parameters)) {
            $tmp = StringFacility::toSnakeCase(implode("_",array_values($this->parameters)));
            return preg_replace("/[^a-z0-9_]+/","",$tmp);
        }
        throw new \Exception('You need to initialize the manager before any uses');
    }
}