<?php

/*
  ======Crud Films=======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		30/04/2015
  Version:	1.0
  Description:
 */

require_once 'basics_bdd.php';
require_once 'crud_Actors.php';
require_once 'crud_keywords.php';

$table_movies = 'movies';
$table_keywords = 'keywords';

function addMovie($title, $date, $img, $video, $synopsis) {
    global $table_movies;
    $dbc = connection();
    $dbc->quote($table_movies);
    $req = "INSERT INTO movies (title, date, imgSrc, videoSrc, synopsis) VALUES (:title, :date, :img, :video, :synopsis)";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':title', $title, PDO::PARAM_STR);
    $requPrep->bindParam(':date', $date);
    $requPrep->bindParam(':img', $img, PDO::PARAM_STR);
    $requPrep->bindParam(':video', $video, PDO::PARAM_STR);
    $requPrep->bindParam(':synopsis', $synopsis, PDO::PARAM_BOOL);
    $requPrep->execute();
    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}

function updateMovie($id, $title, $date, $img, $video, $synopsis){
    global $table_movies;
    $dbc = connection();
    $dbc->quote($table_movies);
    $req = "UPDATE $table_movies SET title=:title, date=:date, imgSrc=:img, videoSrc=:video, synopsis=:synopsis "
            . "WHERE id = :id";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':title', $title, PDO::PARAM_STR);
    $requPrep->bindParam(':date', $date);
    $requPrep->bindParam(':img', $img, PDO::PARAM_STR);
    $requPrep->bindParam(':video', $video, PDO::PARAM_STR);
    $requPrep->bindParam(':synopsis', $synopsis, PDO::PARAM_BOOL);
    $requPrep->bindParam(':id', $id, PDO::PARAM_BOOL);
    $requPrep->execute();
    $requPrep->closeCursor();
}

function searchMovies($key) {
    global $table_movies;

    $condition = "WHERE title like '%$key%' OR synopsis like '%$key%'";
    return getAllFieldsCondition($table_movies, $condition);
}

function getMovieById($id) {
    global $table_movies;
    return getFieldById($id, $table_movies);
}

function getAllMovies() {
    global $table_movies;

    return getAllFields($table_movies);
}

function getPageMovie($page) {
    global $table_movies;

    $req = "SELECT * FROM $table_movies";

    return getPaginationQuerry($page, NB_PAGINATION, $req);
}