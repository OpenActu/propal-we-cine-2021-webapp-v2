<?php

namespace App\Tests\Service\TMDB;

use App\Tests\KernelTestCase;
use App\Service\TMDB\Manager\MovieGenreManager;
use App\Service\TMDB\Manager\MovieManager;
use FOPG\Component\UtilsBundle\Collection\Collection;
use FOPG\Component\UtilsBundle\Env\Env;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;

class MovieManagerTest extends KernelTestCase {

  public function testGetTopRatedByCategory() {
    self::bootKernel();
    /** @var TestContainer $container */
    $container = static::getContainer();
    /** @var MovieGenreManager $mvm */
    $mvm = $container->get(MovieGenreManager::class);
    /** @var Collection $movieGenres */
    $movieGenres=$mvm->findAll();
    /** @var MovieGenreDTO $movieGenre */
    $movieGenre=$movieGenres->current();

    $this->section('Recherche des films à partir de la catégorie '.$movieGenre->getName());
    /** @var MovieManager $mm */
    $mm = $container->get(MovieManager::class);

    $this
      ->given(
        description: 'Récupération des films',
        manager: $mm,
        movieGenreId: $movieGenre->getId()
      )
      ->when(
        description: "J'appelle le service web distant pour récupérer les films de la catégorie ".$movieGenre->getName(),
        callback: function(
          MovieManager $manager,
          int $movieGenreId,
          ?Collection &$movies=null
        ) {
          $movies=$manager->findBy(['with_genres' => $movieGenreId]);
        }
      )
/*      ->then(
        description: "Je dois retrouver ".$numberCategories." catégories",
        callback: function(Collection $movieGenres) { return $movieGenres->count(); },
        result: $numberCategories
      )*/
    ;
  }
}
