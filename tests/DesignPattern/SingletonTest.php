<?php

namespace App\Tests\DesignPattern;

use App\Entity\DTO\CountryDTO;
use App\Tests\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;


class SingletonTest extends KernelTestCase {

  public function testSingleton() {
    self::bootKernel();
    /** @var TestContainer $container */
    $container = static::getContainer();
    
    $this->section("Instanciation d'une entité DTO");

    $defaultCode = 'fr';

    $this 
      ->given(
        description: "J'instancie une entité DTO",
        code: $defaultCode
      )
      ->when(
        description: "Je sors une nouvelle entité",
        callback: function(string $code, ?CountryDTO &$country=null) {
          $country = CountryDTO::getInstance(code: $code);
        }
      )
      ->then(
        description: "Je retrouve l'entité",
        callback: function(CountryDTO $country) {
          return $country->getCode();
        },
        result: $defaultCode
      )
    ;
  }
}
