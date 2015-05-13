<?php

require_once '../includes/specific_funtions.php';
require_once '../includes/crud_Movies.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//TEST des parametres
if (filter_input(INPUT_POST, 'delete')) {
    $id = filter_input(INPUT_POST, 'id');
    
    if ($id && $movie = getMovieById($id)) {
        deleteMovie($id);
        deleteAllKeywordsByMovieId($id);
        deleteAllCreatorsByMovieId($id);
        deleteAllActorsByMovieId($id);
        
        $img = $_SERVER["DOCUMENT_ROOT"].$movie->imgSrc;
        $video = $_SERVER["DOCUMENT_ROOT"].$movie->videoSrc;
        debug($img);
        if (file_exists($img)) {
            unlink($img);
        }
        if (file_exists($video)) {
            unlink($video);
        }
    }
}

header("location: manage.php");

