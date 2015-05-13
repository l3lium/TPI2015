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
require_once 'crud_Keywords.php';
require_once 'crud_Subtitles.php';

$table_movies = 'movies';
$movie_liaison = 'movies_has_';

function countAllMovies() {
    global $table_movies;

    return countFields($table_movies);
}

function addMovie($title, $date, $img, $video, $synopsis) {
    global $table_movies;
    $dbc = connection();
    $dbc->quote($table_movies);
    $req = "INSERT INTO movies (title, date, imgSrc, videoSrc, synopsis) "
            . "VALUES (:title, :date, :img, :video, :synopsis)";
    
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

function updateMovie($id, $title, $date, $img, $video, $synopsis) {
    global $table_movies;
    $dbc = connection();
    $dbc->quote($table_movies);
    $req = "UPDATE $table_movies SET title=:title, date=:date, imgSrc=:img, "
            . "videoSrc=:video, synopsis=:synopsis "
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

function multipleSearch($strKeys, $type = PDO::FETCH_OBJ) {
    global $table_movies;
    $dbc = connection();
    $dbc->quote($table_movies);
    $dbc->quote($strKeys);

    $req = "SELECT DISTINCT m.* FROM $table_movies as m "
            . "INNER JOIN movies_has_actors as ma ON m.id = ma.idMovie "
            . "INNER JOIN movies_has_creators as mc ON m.id = mc.idMovie "
            . "INNER JOIN movies_has_keywords as mk ON m.id = mk.idMovie "
            . "INNER JOIN actors as a ON a.id = ma.idPerson "
            . "INNER JOIN creators as c ON c.id = mc.idPerson "
            . "INNER JOIN keywords as k ON k.idKeyword = mk.idKeyword "
            . "WHERE MATCH(m.title, m.synopsis, a.firstName, a.lastName, "
            .   "c.firstName, c.lastName, k.label) "
            . "AGAINST ('$strKeys' IN BOOLEAN MODE) OR "
            . "MATCH (m.date) AGAINST('$strKeys' IN BOOLEAN MODE)";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->execute();
    $data = $requPrep->fetchAll($type);
    $requPrep->closeCursor();
    return $data;
}

function getMovieById($id) {
    global $table_movies;
    return getFieldById($id, $table_movies);
}

function getAllMovies($col = 1, $sort = true) {
    global $table_movies;
    $cond = "ORDER BY $col ";
    $cond.= ($sort) ? "ASC" : "DESC";
    return getAllFieldsCondition($table_movies, $cond);
}

function getNewMovies() {
    $cond = "WHERE date < NOW() ORDER BY date DESC";
    return getPageMovie(1, $cond, NB_ITEM_HOME);
}

function getUpComingMovies() {
    $cond = "WHERE date > NOW() ORDER BY date";
    return getPageMovie(1, $cond, NB_ITEM_HOME);
}

function getPageMovie($page, $condition = "ORDER BY title ASC", $nbItems = NB_PAGINATION) {
    global $table_movies;

    $req = "SELECT * FROM $table_movies "
            . "$condition ";
    
    return getPaginationQuerry($page, $nbItems, $req);
}

function deleteMovie($id) {
    global $table_movies;

    return deleteFieldById($id, $table_movies);
}

/*
SELECT *
FROM movies
WHERE MATCH(title, synopsis) AGAINST ('dada derp' IN BOOLEAN MODE)
 *  */

/*
 * SELECT DISTINCT *
FROM movies as m
INNER JOIN movies_has_actors as ma ON m.id = ma.idMovie
INNER JOIN movies_has_creators as mc ON m.id = mc.idMovie
INNER JOIN movies_has_keywords as mk ON m.id = mk.idMovie
INNER JOIN actors as a ON a.id = ma.idPerson
INNER JOIN creators as c ON c.id = mc.idPerson
INNER JOIN keywords as k ON k.idKeyword = mk.idKeyword
WHERE MATCH(m.title, m.synopsis, a.firstName, a.lastName, k.label) 
 * AGAINST ('*key* *derp*' IN BOOLEAN MODE)
 */