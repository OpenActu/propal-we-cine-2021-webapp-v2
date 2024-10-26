<?php

namespace App\Tests\Service\TMDB;

use App\Tests\KernelTestCase;
use App\Service\TMDB\Manager\MovieGenreManager;
use App\Service\TMDB\Manager\MovieManager;
use FOPG\Component\UtilsBundle\Collection\Collection;
use FOPG\Component\UtilsBundle\Env\Env;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;

class MovieGenreManagerTest extends KernelTestCase {
  
  public function testGetCategories() {
    self::bootKernel();
    /** @var TestContainer $container */
    $container = static::getContainer();
    /** @var MovieGenreManager $mvm */
    $mvm = $container->get(MovieGenreManager::class);
    /** @var int $numberCategories Nombre de catégorie connues */
    $numberCategories=19;

    $this->section('Recherche des catégories de films');

    $this
      ->given(
        description: 'Récupération des catégories',
        manager: $mvm,
        numberCategories: $numberCategories
      )
      ->when(
        description: "J'appelle le service web distant pour récupérer les catégories",
        callback: function(
          MovieGenreManager $manager,
          ?Collection &$movieGenres=null
        ) { $movieGenres=$manager->findAll(); }
      )
      ->then(
        description: "Je dois retrouver ".$numberCategories." catégories",
        callback: function(Collection $movieGenres) { return $movieGenres->count(); },
        result: $numberCategories
      )
    ;
  }
}
