import React from 'react';

import { Card, Button } from 'react-bootstrap';
import Movie from '../../components/Movie';
import Image from '../../components/Image';
import { trans, MOVIE_INDEX_VOTE_COUNT } from '../../../translator';

export default function ({title, voteAverage, voteCount,posterPath,defaultSrc,releaseYear,overview}) {
    return (
        <Card>
            <div className="row g-0">
                <Card.Header>
                    <h5>
                        {title} <span className="badge bg-danger">{voteAverage}</span> ({voteCount} {trans(MOVIE_INDEX_VOTE_COUNT)})
                    </h5>
                </Card.Header>
                
                    <div className="col-2">
                        <Image format="w500" filename={posterPath} alt={title} defaultSrc={defaultSrc}/>
                    </div>
                    <div className="col-10">
                    <Card.Body> 
                        <h5>
                            <Card.Title>{releaseYear}</Card.Title>
                        </h5>
                        <Card.Text>{overview}</Card.Text>
                        </Card.Body>
                    </div>
                    

            </div>
        </Card>
    );
}