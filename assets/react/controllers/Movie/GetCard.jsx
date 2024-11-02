import React,{useState} from 'react';

import { Card, Button, Spinner } from 'react-bootstrap';
import Movie from '../../components/Movie';
import Image from '../../components/Image';
import { trans, MOVIE_INDEX_VOTE_COUNT,MOVIE_INDEX_SHOW_DETAILS } from '../../../translator';

export default function ({movieValue, defaultSrc}) {

    const DEFAULT_LOCALE="fr-FR";
    const movie=JSON.parse(movieValue);
    const voteAverage=new Intl.NumberFormat(DEFAULT_LOCALE).format(movie.voteAverage);
    const releaseDate=new Date(movie.releaseDate);
    const [loading, setLoading]=useState(false);

    function freezeBtns() {
        /* désactivation des boutons d'ouverture de modale */
        $(".open-modal-movie").addClass("disabled");
      }
      
      function activeBtns() {
        /* activation des boutons d'ouverture de modale */
        $(".open-modal-movie").removeClass("disabled");
      }
    function populateModal(data) {
        let tmp="";
        data.genres.map((item) => { tmp+='<span class="badge bg-secondary">'+item['name']+'</span>&nbsp;'; });
        
        $("#modal_movie_title").text(data.title);
        $("#modal_movie_id").text(data.tmdbId);
        $("#modal_movie_imdb_id").text(data.imdbId);
        $("#modal_movie_original_title").text(data.originalTitle);
        $("#modal_movie_budget").text(data.budget);
        $("#modal_movie_revenue").text(data.revenue);
        $("#modal_movie_movie_genres").html(tmp);
        $("#modal_movie_belongs_to_collection").text(data.belongsToCollection?data.belongsToCollection.name:'');
        $("#modal_movie_original_language").text(data.originalLanguage?data.originalLanguage.code:'');
    }

    function handleClick() {
        const route = Routing.generate('api_movie_dto_GET_item',{id: movie.id});
        setLoading(true);
        freezeBtns();
        fetch(route)
            .then((response) => response.json())
            .then((data) => {
                activeBtns();
                populateModal(data);
                $('#modal-movie').modal('show');
                setLoading(false);
            })
            .catch((err) => activeBtns())
        ;
    }

    return (
        <Card>
            <div className="row g-0">
                <Card.Header>
                    <h5>
                        {movie.title} <span className="badge bg-danger">{voteAverage}</span> ({movie.voteCount} {trans(MOVIE_INDEX_VOTE_COUNT)})
                    </h5>
                </Card.Header>
                
                <div className="col-2">
                    <Image format="w500" filename={movie.poster.filename.substr(1)} alt={movie.title} defaultSrc={defaultSrc}/>
                </div>
                <div className="col-10">
                    <Card.Body> 
                        <h5>
                            <Card.Title>{releaseDate.toLocaleDateString(DEFAULT_LOCALE,{year: 'numeric'})}</Card.Title>
                        </h5>
                        <Card.Text>{movie.overview}</Card.Text>
                        <Button variant="primary" onClick={handleClick} className="open-modal-movie">
                            {loading && 
                            <Spinner animation="border" role="status" className="spinner-border spinner-border-sm"></Spinner>
                            }
                            {trans(MOVIE_INDEX_SHOW_DETAILS)}
                        </Button>
                    </Card.Body>
                </div>
            </div>
        </Card>
    );
}