import React, {useState, useEffect} from 'react';

const DEFAULT_FORMAT='w500';

const Image = ({format, filename, defaultSrc}) => {
    const [src,setSrc]=useState(null);
    const url = Routing.generate('image_get',{format:format,filename:filename});
    useEffect(() => {
        fetch(url) 
        .then((response) => response.blob())
        .then((blob) => setSrc(URL.createObjectURL(blob)));
    },[]);
    
    return (
        <>
        {(null!==src) && 
        <img
            src={src}
            className="img-fluid img-thumbnail"
        />
        }
        {(null===src) && 
        <img
            src={defaultSrc}
            className="img-fluid img-thumbnail"
        />
        }
        </>
    )
}

export default Image;