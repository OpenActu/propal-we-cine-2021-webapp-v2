import { Minio } from 'minio-js';

var MinioConfig = null;
export const startMinio = function(conf) {
    MinioConfig=conf;
}

export const receiveFromMinio = async function(bucket, path) {
    let minioClient = new Minio.Client(MinioConfig);
    return await minioClient.getObject(bucket, path);
}