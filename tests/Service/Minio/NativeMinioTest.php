<?php

namespace App\Tests\Service\Minio;

use App\Utils\Env\Env;
use App\Tests\KernelTestCase;
use App\Service\Minio\Client as MinioClient; 

class NativeMinioTest extends KernelTestCase {
    public function testGetCategories() {
        self::bootKernel();
        /** @var TestContainer $container */
        $container = static::getContainer();
        /** @var MovieGenreManager $mvm */
        $s3 = $container->get(MinioClient::class);

        $this->section('Validation des appels à Minio');

        $this
            ->given(
                description: "J'utilise une session de Minio",
                s3: $s3
            )
            ->when(
                description: 'Je stocke une valeur dans Minio',
                callback: function(MinioClient $s3) { $s3->putString('testkey','welcome'); }
            )
            ->then(
                description: 'Je retrouve la valeur stockée',
                callback: function(MinioClient $s3): bool { return ($s3->getString('testkey') === 'welcome'); },
                result: true
            )
        ;
    }
}
