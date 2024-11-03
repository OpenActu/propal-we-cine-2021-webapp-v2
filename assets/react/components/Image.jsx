import React, {useState, useEffect} from 'react';
import {Image as BootstrapImage} from 'react-bootstrap';
import { initMinio, putObject } from '../../js/utils/minio';
const DEFAULT_FORMAT='w500';

const pubObj2 = function() {
 //   alert('ici');

} 
const Image = ({format, filename, defaultSrc,alt=""}) => {
    const [src,setSrc]=useState(null);
    const url = Routing.generate('image_get',{format:format,filename:filename});
   // console.log(process.env.APP_ENV);
    useEffect(() => {
        /** 
        fetch(url) 
        .then((response) => response.blob())
        .then((blob) => setSrc(URL.createObjectURL(blob)));
        */
        initMinio({
            endPoint: 'localhost',
            port: 9000,
            useSSL: false,
            accessKey: 'mYOCgRwJ4Y0Y1h631j5K',
            secretKey: 'jQSlr5ydkAD4z5x6gRPtEQeBdNJwN5sohtjR0Aww',
          })
          const buffer = new ArrayBuffer(8);
          //putObject("documents", buffer, "test.png");
          pubObj2();
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