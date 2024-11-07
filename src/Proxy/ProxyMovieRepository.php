<?php 
namespace App\Proxy;

use App\Contracts\DesignPattern\ProxyInterface;
use App\Entity\Movie;
use App\Exception\Proxy\NoIdentifierException;
use App\Entity\DTO\MovieDTO;
use App\Service\Cache\CacheManager;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\TMDB\Manager\MovieManager;
use App\Message\MovieDTOReceiver;
use App\Repository\MovieRepository;

class ProxyMovieRepository implements ProxyInterface {

    private ?int $id=null;
    private ?string $locale=null;

    public function __construct(
        private CacheManager $cache,
        private MessageBusInterface $bus,
        private SerializerInterface $serializer,        
        private MovieManager $mm,
        private MovieRepository $mr
    ) { }
    
    public function setId(int $id): static {
        $this->id = $id;
        return $this;
    }

    public function setLocale(string $locale): static {
        $this->locale = $locale;
        return $this;
    }

    public function serializeToArray(): array {
        /** @var array $data */
        $data=[];
        if((null === $this->id)||(null === $this->locale)) 
            throw new NoIdentifierException();
        /** @var bool $hasCache */
        $hasCache = $this->cache->init(['class' => get_called_class(),'id' => $this->id])->exists();
        if(false === $hasCache) {
            /** @var ?Movie $movie */
            $movie = $this->mr->findOneBy(['locale' => $this->locale, 'tmdbId' => $this->id]);
            if(null === $movie) {  
                /** @var ?MovieDTO $movieDTO */
                $movieDTO= $this->mm->setLocale($this->locale)->find($this->id);
                if($movieDTO) {
                    $data = $movieDTO->serializeToArray();
                    $this->bus->dispatch(new MovieDTOReceiver($data));
                }
            }
            else {
                $data = $this->serializer->normalize($movie,null,['groups' => 'api_movie_dto_GET_item']);
            }
            $this->cache->save($data);
        }
        else {
            $data = $this->cache->get();
        }
        return $data;
    }
}