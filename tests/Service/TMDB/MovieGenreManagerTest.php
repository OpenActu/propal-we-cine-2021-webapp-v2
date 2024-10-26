<?php

namespace App\Tests\Service\TMDB;

use App\Tests\KernelTestCase;
use App\Service\TMDB\MovieGenreManager;
use FOPG\Component\UtilsBundle\Env\Env;

class MovieGenreManagerTest extends KernelTestCase {
  public function testGetList() {
    //dump(Env::get('APP_ENV'));die;
    self::bootKernel();
    $container = static::getContainer();
    $mvm = $container->get(MovieGenreManager::class);

    $this->section('Recherche de films');

    $this
      ->given(
        description: 'Récupération de la liste des films',
        manager: $mvm
      )
      ->when(description: "J'appelle le service web distant pour récupérer la liste des films", callback: function(MovieGenreManager $manager) {
        $movieGenres=$manager->findAll();
      })
      ->then(description: 'success', callback: function() { return true; }, result: true)
    ;
  }
}
