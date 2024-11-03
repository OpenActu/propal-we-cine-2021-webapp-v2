import React, {useState, useEffect} from 'react';
import {Image as BootstrapImage} from 'react-bootstrap';
import { startMinio, sendToMinio, receiveFromMinio } from '../../js/utils/minio';
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
            endPoint: 'localhost',
            port: 9000,
            useSSL: false,
            accessKey: 'mYOCgRwJ4Y0Y1h631j5K',
            secretKey: 'jQSlr5ydkAD4z5x6gRPtEQeBdNJwN5sohtjR0Aww',
        });

        receiveFromMinio("documents", build_path("fr", format, filename))
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