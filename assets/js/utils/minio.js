import { initMinio, putObject, Minio } from 'minio-js';

var MinioConfig = null;
export const startMinio = function(conf) {
    initMinio(conf);
    MinioConfig=conf;
}

export const sendToMinio = function(bucket, buffer, path) {
    putObject(bucket, buffer, path);
}

export const receiveFromMinio = async function(bucket, path) {
    let minioClient = new Minio.Client(MinioConfig);
    return await minioClient.getObject(bucket, path);
}