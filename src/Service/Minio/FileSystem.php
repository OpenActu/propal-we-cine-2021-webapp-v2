<?php 
namespace App\Service\Minio;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem as LeagueFS;
use App\Utils\Env\Env;
use App\Exception\Minio\InvalidFilenameException;

class FileSystem {

    private ?LeagueFS $filesystem=null;
    
    public function __construct(
    ) {
        $client = new S3Client([ 
            'version' => 'latest', 
            'region' => 'us-east-1', 
            'endpoint' => Env::get('MINIO_HOST'), 
            'use_path_style_endpoint' => true, 
            'credentials' => [ 
                'key' => Env::get('MINIO_ACCESS_KEY'), 
                'secret' => Env::get('MINIO_SECRET_KEY'), 
            ], 
        ]);
        $adapter = new AwsS3V3Adapter($client,Env::get('MINIO_BUCKET'));
        $this->filesystem= new LeagueFS($adapter);
    }

    public function write(string $path, string $originFilename): static {
        $realFilename = realpath($originFilename);
        if(!$realFilename)
            throw new InvalidFilenameException("Le fichier $originFilename n'existe pas !");
        $content = file_get_contents($realFilename);
        $this->filesystem->write($path, $content);
        return $this;
    }

    public function writeContent(string $path, string $content): static {
        $this->filesystem->write($path, $content);
        return $this;
    }
    public function read(string $path): ?string {
        try { return $this->filesystem->read($path); }
        catch(\Exception $e) { }
        return null;

    }
}