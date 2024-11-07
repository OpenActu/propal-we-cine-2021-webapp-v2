<?php 
namespace App\Decorator\Image;

use App\Utils\DesignPattern\Decorator\AbstractDecorator;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\ImageReceiver;

class ImageDispatcherDecorator extends AbstractDecorator {
    public function __construct(private MessageBusInterface $bus) { }

    public function download(string $filename, string $format, string $locale): ?string {
        try {
            $content = parent::download(filename: $filename, format: $format, locale: $locale);
            if(!empty($content)) 
                $this->bus->dispatch(new ImageReceiver(format: $format, filename: $filename, locale: $locale));
            return $content;
        }
        catch(\BadMethodCallException $e) { return null; }

    }
}