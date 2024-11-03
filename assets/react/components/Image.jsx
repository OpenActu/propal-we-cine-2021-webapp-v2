import React, {useState, useEffect} from 'react';
import {Image as BootstrapImage} from 'react-bootstrap';
import { startMinio, receiveFromMinio } from '../../js/utils/minio';
const DEFAULT_FORMAT='w500';
const IMAGE_PATH='images';
function build_path(locale, format, filename) { 
    const url = IMAGE_PATH+'/'+locale+'/'+format+'/'+filename;
    return url; 
}

const Image = ({format, filename, defaultSrc,alt=""}) => {
    const [src,setSrc]=useState(null);
    var url = Routing.generate('image_get',{format:format,filename:filename});

    useEffect(() => {
        const data = [];
        startMinio({
            endPoint: process.env.MINIO_JS_HOSTNAME,
            port: process.env.MINIO_JS_PORT,
            useSSL: process.env.MINIO_JS_USE_SSL,
            accessKey: process.env.MINIO_READER_ACCESS_KEY,
            secretKey: process.env.MINIO_READER_SECRET_KEY,
        });

        receiveFromMinio(process.env.MINIO_BUCKET, build_path("fr", format, filename))
        .then((stream) => {
            stream.on('data', chunk => { data.push(chunk); });
            stream.on('end', () => { 
                const imageBuffer = Buffer.concat(data); 
                const base64Image = imageBuffer.toString('base64'); 
                setSrc(`data:image/jpeg;base64,${base64Image}`); 
            });
            stream.on('error', () => {
                fetch(url) 
                .then((response) => response.blob())
                .then((blob) => setSrc(URL.createObjectURL(blob)));
            })  
        })
        .catch((err) => {
            fetch(url) 
            .then((response) => response.blob())
            .then((blob) => setSrc(URL.createObjectURL(blob)));
        });  
    },[]);
    
    return (
        <>
        {(null!==src) && 
        <BootstrapImage
            src={src}
            className="img-fluid img-thumbnail"
            alt={alt}
        />
        }
        {(null===src) && 
        <BootstrapImage
            src={defaultSrc}
            className="img-fluid img-thumbnail"
        />
        }
        </>
    )
}

export default Image;