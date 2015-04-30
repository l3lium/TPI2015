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

$table = 'movies';

function addFilm($title, $date, $img, $video, $synopsis) {
    global $table;
    $dbc = connection();
    $dbc->quote($table);
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

function searchFilm($key) {
    global $table;

    $condition = "WHERE title like '%$key%' OR synopsis like '%$key%'";
    return getAllFieldsCondition($table, $condition);
}

function getFilmById($id) {
    global $table;
    return getFieldById($id, $table);
}

function getAllFilms() {
    global $table;

    return getAllFields($table);
}

function getPageFilms($page) {
    global $table;

    $req = "SELECT * FROM $table";

    return getPaginationQuerry($page, NB_PAGINATION, $req);
}
