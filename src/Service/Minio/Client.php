<?php 
namespace App\Service\Minio;

use Aws\S3\S3Client; 
use App\Utils\Env\Env;

class Client extends S3Client {

    private ?S3Client $s3Client=null;
    public function __construct() {
        $this->s3Client = new S3Client([ 
            'version' => 'latest', 
            'region' => 'us-east-1', 
            'endpoint' => Env::get('MINIO_HOST'), 
            'use_path_style_endpoint' => true, 
            'credentials' => [ 
                'key' => Env::get('MINIO_ACCESS_KEY'), 
                'secret' => Env::get('MINIO_SECRET_KEY'), 
            ], 
        ]);
    }

    public function getString(string $key): ?string {
        return $this
            ->s3Client
            ->getObject([ 'Bucket' => Env::get('MINIO_BUCKET'), 'Key' => $key ])
            ->get('Body')
            ->getContents();
    }

    public function putString(string $key, string $value): static {
        $this->s3Client->putObject([ 'Bucket' =>  Env::get('MINIO_BUCKET'), 'Key' => $key,'Body' => $value ]);
        return $this;
    }
}