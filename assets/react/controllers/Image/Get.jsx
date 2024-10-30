import React from 'react';

import Image from '../../components/Image';

export default function ({format,filename,defaultSrc}) {
    return (
        <>
            <Image format={format} filename={filename} defaultSrc={defaultSrc}/>
        </>
    );
}