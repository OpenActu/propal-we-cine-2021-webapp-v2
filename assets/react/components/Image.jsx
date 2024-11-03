import React, {useState, useEffect} from 'react';
import {Image as BootstrapImage} from 'react-bootstrap';
const DEFAULT_FORMAT='w500';
 
const Image = ({format, filename, defaultSrc,alt=""}) => {
    const [src,setSrc]=useState(null);
    const url = Routing.generate('image_get',{format:format,filename:filename});
   // console.log(process.env.APP_ENV);
    useEffect(() => {
        
        fetch(url) 
        .then((response) => response.blob())
        .then((blob) => setSrc(URL.createObjectURL(blob)));

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