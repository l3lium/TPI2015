<?php
/*
  ======Crud Actors=======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		06/05/2015
  Version:	0.4
  Description:
 */

require_once 'basics_bdd.php';

$table_Actors = 'actors';
$table_Creators = 'creators';
$laison = 'movies_has_';

function addActor(){
    
}

function getActorById(){
    
}

function updateActor(){
    
}

/** addActorsMovie
 * Ajoute dans des acteurs à un film dans la bdd
 * @global string $table_Actors
 * @param int $id
 * @param array $actors
 * @return type
 */
function addActorsMovie($id, $actors){
    global $table_Actors;
    return addPersonsMovie($id, $actors, $table_Actors);
}

/** addCreatorsMovie
 * Ajoute dans des réalisateurs à un film dans la bdd
 * @global string $table_Creators
 * @param int $id
 * @param array $creators
 * @return type
 */
function addCreatorsMovie($id, $creators){
    global $table_Creators;
    return addPersonsMovie($id, $creators, $table_Creators);
}

function addPersonsMovie($id, $persons, $table){
    global $laison;
    $newTable = $laison.$table;
    $dbc = connection();
    $dbc->quote($newTable);
    
    $req = "INSERT INTO $newTable (idMovie, idPerson) VALUES (:idMovie, :idPerson)";
    $requPrep = $dbc->prepare($req);
    foreach ($persons as $value) {
        $requPrep->bindParam(":idMovie", $id, PDO::PARAM_INT);
        $requPrep->bindParam(":idPerson", $value, PDO::PARAM_INT);
        $requPrep->execute();
    }
    
    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}

function getAllActors(){
    global $table_Actors;
    return getAllFields($table_Actors);
}

function getAllCreators(){
    global $table_Creators;
    return getAllFields($table_Creators);
}

function getActorsByMovieId($id, $type = PDO::FETCH_OBJ){
    global $table_Actors;
    return getPeopleByMovieId($id, $table_Actors, $type);
}

function getCreatorsByMovieId($id, $type = PDO::FETCH_OBJ){
    global $table_Creators;
    return getPeopleByMovieId($id, $table_Creators, $type);
}

function getPeopleByMovieId($id, $table, $type = PDO::FETCH_OBJ){
    global $laison;
    $newTable = $laison.$table;

    $dbc = connection();
    $dbc->quote($newTable);
    $dbc->quote($table);
    $req = "SELECT a.id, a.firstName, a.lastName FROM $newTable ma "
            . "INNER JOIN $table AS a ON a.id = ma.idPerson WHERE ma.idMovie = :id";

    $requPrep = $dbc->prepare($req);
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();
    
    $data= $requPrep->fetchAll($type);
    $requPrep->closeCursor();
    return $data;
}

function getActorsIdByMovieId($id) {
    return array_column(getActorsByMovieId($id, PDO::FETCH_ASSOC), 'id');
}

function getCreatorsIdByMovieId($id) {
    return array_column(getCreatorsByMovieId($id, PDO::FETCH_ASSOC), 'id');
}

function deleteAllActorsByMovieId($id){
    global $table_Actors;
    
    $condition="WHERE idMovie = $id";
    return deleteFieldCondition($table_Actors, $condition);
}

function deleteAllCreatorsByMovieId($id){
    global $table_Creators;
    
    $condition="WHERE idMovie = $id";
    return deleteFieldCondition($table_Creators, $condition);
}