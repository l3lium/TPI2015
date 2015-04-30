<?php
/*
  ======Crud Actors=======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		30/04/2015
  Version:	1.0
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

function getUpdateActor(){
    
}

function getAllActorsByFilmId($id){
    global $table_Actors;
    return getAllPeopleByFilmId($id, $table_Actors);
}

function getAllCreatorsByFilmId($id){
    global $table_Creators;
    return getAllPeopleByFilmId($id, $table_Creators);
}

function getAllPeopleByFilmId($id, $table){
    global $laison;
    $newTable = $laison.$table;
    debug($newTable);
    $dbc = connection();
    $dbc->quote($newTable);
    $dbc->quote($table);
    $req = "SELECT a.firstName, a.lastName FROM $newTable ma "
            . "INNER JOIN $table AS a ON a.id = ma.idPerson WHERE ma.idMovie = :id";
    debug($req);
    $requPrep = $dbc->prepare($req);
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();
    
    $data= $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}