<?php 
namespace App\Service\Cache;

use Symfony\Contracts\Cache\CacheInterface;
use App\Utils\String\StringFacility;
use App\Utils\Env\Env;

class CacheManager {
    
    private array $parameters=[];
    
    public function __construct(private CacheInterface $cache) {}
    
    public function init(array $parameters): static { $this->parameters=$parameters; return $this; }
    
    public function exists(): bool {
        if(Env::get('ACTIVATE_CACHE_MANAGER') === false)
            return false;
        $key = $this->getKey();
        return $this->cache->hasItem($key);
    }

    public function get(): ?array {
        if(Env::get('ACTIVATE_CACHE_MANAGER') === false)
            return null;
        $obj = $this->cache->getItem($this->getKey());
        return $obj->get();
        
    }

    public function save(array $data): bool {
        if(Env::get('ACTIVATE_CACHE_MANAGER') === false)
            return false;
        $obj = $this->cache->getItem($this->getKey());
        $obj->set($data);
        return $this->cache->save($obj);
    }

    public function delete(): bool {
        if(Env::get('ACTIVATE_CACHE_MANAGER') === false)
            return false;
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