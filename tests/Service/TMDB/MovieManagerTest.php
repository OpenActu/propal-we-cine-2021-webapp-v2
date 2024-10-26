<?php

namespace App\Tests\Service\TMDB;

use App\Tests\KernelTestCase;
use app\Entity\DTO\MovieDTO;
use App\Service\TMDB\Manager\MovieGenreManager;
use App\Service\TMDB\Manager\MovieManager;
use FOPG\Component\UtilsBundle\Collection\Collection;
use FOPG\Component\UtilsBundle\Env\Env;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;

class MovieManagerTest extends KernelTestCase {

  public function testSearch() {
    self::bootKernel();
    /** @var TestContainer $container */
    $container = static::getContainer();

    $this->section('Recherche des films en texte libre');
    /** @var MovieManager $mm */
    $mm = $container->get(MovieManager::class);
    $query = 'napoléon';
    $this
      ->given(
        description: "Récupération des films contenant le terme $query",
        manager: $mm,
        query: $query
      )
      ->when(
        description: "J'appelle le service web distant pour récupérer les films contenant ".$query,
        callback: function(
          MovieManager $manager,
          string $query,
          ?Collection &$movies=null,
          ?int &$totalPages=null,
          ?int &$totalResults=null
        ) {
          $movies=$manager->search(query: $query,page: 1);
          $totalPages=$manager->getTotalPages();
          $totalResults=$manager->getTotalResults();
        }
      )
      ->then(
        description: "Je récupère les résultats contenant $query",
        callback: function(Collection $movies, int $totalPages, int $totalResults): bool {
          return ($totalResults > 0);
        },
        result: true
      )
    ;
  }
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
          ?Collection &$movies=null,
          ?int &$totalPages=null,
          ?int &$totalResults=null
        ) {
          $movies=$manager->findBy(params: ['with_genres' => $movieGenreId], sortBy: ['popularity' => 'desc'], page: 1);
          $totalPages=$manager->getTotalPages();
          $totalResults=$manager->getTotalResults();
        }
      )
      ->then(
        description: "Je dois retrouver au moins un film",
        callback: function(Collection $movies,int $totalPages, int $totalResults) {
          $movie = $movies->current();
          $check = !empty($movie) &&
                  !empty($movie->getTitle()) &&
                  !empty($movie->getId()) &&
                  ($totalPages > 1) &&
                  ($totalResults > 1)
          ;
          return $check;
        },
        result: true
      )
    ;
  }

  public function testFind() {
    self::bootKernel();
    /** @var TestContainer $container */
    $container = static::getContainer();
    /** @var MovieManager $mm */
    $mm = $container->get(MovieManager::class);

    $movieData = [
      'id' => 1184918,
      'adult' => false,
      'title' => 'Le Robot sauvage',
      'backdrop_path' => '/417tYZ4XUyJrtyZXj7HpvWf1E8f.jpg',
      'original_title' => 'The Wild Robot',
      'poster_path' => '/yJGZlmCmQGX6PGe9f0LtZffLHhZ.jpg',
      'release_date' => new \DateTime('2024-09-12'),
      'imdb_id' => 'tt29623480',
    ];
    $movieId = $movieData['id'];
    $movieTitle = $movieData['title'];
    $this->section('Récupération des détails du film '.$movieTitle);

    $this
      ->given(
        description: 'Je souhaite consulter la fiche détaillée du film '.$movieTitle,
        manager: $mm,
        id: $movieId,
        data: $movieData
      )
      ->when(
        description: 'Je consulte la fiche détaillée du film '.$movieTitle,
        callback: function(MovieManager $manager,int $id, ?MovieDTO &$movie=null) {
          $movie = $manager->find($id);
        }
      )
      ->then(
        description: 'Je retrouve les détails du film '.$movieTitle,
        callback: function(?MovieDTO $movie,array $data): bool {
          return
            ($movie->getId() === $data['id']) &&
            ($movie->getAdult() === $data['adult']) &&
            ($movie->getTitle() === $data['title']) &&
            ($movie->getBackdropPath() === $data['backdrop_path']) &&
            ($movie->getOriginalTitle() === $data['original_title']) &&
            ($movie->getPosterPath() === $data['poster_path']) &&
            ($movie->getReleaseDate() == $data['release_date']) &&
            ($movie->getImdbId() === $data['imdb_id'])
          ;
        },
        result: true
      )
    ;
  }
}
