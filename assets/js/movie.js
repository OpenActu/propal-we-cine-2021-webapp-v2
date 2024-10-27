function freezeBtns(whoami) {
  /* désactivation des boutons d'ouverture de modale */
  $(".open-modal-movie").addClass("disabled");
  /* ajout du spinner */
  $(whoami).find(".open-modal-movie-spinner").removeClass("hide");
}

function activeBtns(whoami) {
  /* activation des boutons d'ouverture de modale */
  $(".open-modal-movie").removeClass("disabled");
  /* masquage du spinner */
  $(whoami).find(".open-modal-movie-spinner").addClass("hide");
}

function populateModal(data) {
  let tmp="";
  data.movieGenres.map((item) => { tmp+='<span class="badge bg-secondary">'+item['name']+'</span>&nbsp;'; });

  $("#modal_movie_title").text(data.title);
  $("#modal_movie_id").text(data.id);
  $("#modal_movie_imdb_id").text(data.imdbId);
  $("#modal_movie_original_title").text(data.originalTitle);
  $("#modal_movie_budget").text(data.budget);
  $("#modal_movie_revenue").text(data.revenue);
  $("#modal_movie_movie_genres").html(tmp);
  $("#modal_movie_belongs_to_collection").text(data.belongsToCollection?data.belongsToCollection.name:'');
  $("#modal_movie_original_language").text(data.originalLanguage?data.originalLanguage.code:'');
}
/* gestion de l'ouverture de la modale */
$(".open-modal-movie").click(function() {
  const id = $(this).data().movieId;
  const whoami = this;
  const route = Routing.generate('api_movie_GET_item',{id: id});
  freezeBtns(whoami);
  fetch(route)
    .then((response) => response.json())
    .then((data) => {
      activeBtns(whoami);
      populateModal(data);
      $('#modal-movie').modal('show');
    })
    .catch((err) => activeBtns(whoami))
  ;
});
