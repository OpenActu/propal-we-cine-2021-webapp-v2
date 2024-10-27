/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

const $ = require('jquery');
window.jQuery = $;
window.$ = $;

const routes = require('../public/js/fos_js_routes.json');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min';
Routing.setRoutingData(routes);
window.Routing = Routing;

require('bootstrap');
require('webpack-jquery-ui');

$(document).ready(() => {
  $("#navbar_movie_search").autocomplete({
    source: Routing.generate('api_movie_GET_search_collection'),
    minLength:3,
    select: function( event, ui ) { },
    create: function( event, ui) {
      $(this).data('ui-autocomplete')._renderItem = function( ul, item ) {
        return $( "<li class='ui-menu-item'>" )
          .append( "<div>" + item.title + "</div>" )
          .appendTo( ul );
      };
    },
    response: function(event, ui) {
      const id = this.id;
      if (!ui.content.length) {
          var noResult = { value:"",label:"Aucun résultat",desc:"Aucun résultat" };
          ui.content.push(noResult);
      }
    }
  });
});
