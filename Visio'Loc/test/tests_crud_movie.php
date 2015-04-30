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
debug(getFilmById(1));

//debug(addFilm("dadadada", "2015-12-12", "img", "video", "je suis un synopsis"));

echo "recherche 'saas' :";
debug(searchFilm("saas"));

debug(getAllActorsByFilmId(1));
debug(getAllActorsByFilmId(2));

debug(getAllCreatorsByFilmId(1));
debug();

