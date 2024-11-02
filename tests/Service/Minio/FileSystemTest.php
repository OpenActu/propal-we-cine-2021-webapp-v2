<?php

namespace App\Tests\Service\Minio;

use App\Tests\KernelTestCase;
use App\Service\Minio\FileSystem as FSO; 

class FileSystemTest extends KernelTestCase {
    public function testGetCategories() {
        self::bootKernel();
        /** @var TestContainer $container */
        $container = static::getContainer();
        /** @var MovieGenreManager $mvm */
        $fso = $container->get(FSO::class);

        $this->section('Validation des appels à Minio');

        $this
            ->given(
                description: "J'utilise un FSO de Minio",
                fso: $fso
            )
            ->when(
                description: 'Je stocke une valeur dans Minio',
                callback: function(FSO $fso) {
                    $fso->write('tests/new-sample.jpeg', realpath(__DIR__.'/docs/sample.jpeg'));
                }
            )
            ->then(
                description: 'Je retrouve la valeur stockée',
                callback: function(FSO $fso): bool { 
                    return (null !== $fso->read('tests/new-sample.jpeg'));
                },
                result: true
            )
        ;
    }
}
