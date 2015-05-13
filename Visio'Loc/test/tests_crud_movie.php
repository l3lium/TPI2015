<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../includes/specific_funtions.php';
require_once '../includes/crud_Movies.php';

//debug(getAllFilms());

echo "id 1 :";
debug(getMovieById(1));

//debug(addFilm("dadadada", "2015-12-12", "img", "video", "je suis un synopsis"));

echo "recherche 'saas' :";
debug(searchMovies("saas"));

debug(getActorsByMovieId(1));
debug(getActorsByMovieId(2));

debug(getCreatorsByMovieId(1));
debug(updateMovie(1, "test Update", "2015-2-2", "test Update imgsrc", "test Update video src", "test Update synopsis"));

debug(addSubtitle(1, "fr", "test"));
updateSub(1, "fr", "en", "testupdate");