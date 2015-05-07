<?php
/*
  ======Crud Keywords=======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		06/05/2015
  Version:	0.1
  Description:
 */

$table_keys = "keywords";
$liaison = "movies_has_";

function getAllKeywords(){
    global $table_keys;
    return getAllFields($table_keys);
}

function addKeywordsMovie($id, $keys) {
    global $laison;
    global $table_keys;
    $newTable = $laison . $table_keys;
    $dbc = connection();
    $dbc->quote($newTable);

    $req = "INSERT INTO $newTable (idMovie, idKeyword) VALUES (:idMovie, :idKey)";
    $requPrep = $dbc->prepare($req);


    foreach ($keys as $value) {
        $requPrep->bindParam(":idMovie", $id, PDO::PARAM_INT);
        $requPrep->bindParam(":idKey", $value, PDO::PARAM_INT);
        $requPrep->execute();
    }

    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}

function getKeysByMovieId($id) {
    global $laison;
    global $table_keys;
    $newTable = $laison . $table_keys;

    $dbc = connection();
    $dbc->quote($newTable);
    $dbc->quote($table_keys);
    $req = "SELECT k.idKeyword, k.label FROM $table_keys k "
            . "INNER JOIN $newTable AS mk ON mk.idKeyword = k.idKeyword WHERE mk.idMovie = :id";

    $requPrep = $dbc->prepare($req);
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();

    $data = $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

function getKeysIdByMovieId($id) {
    global $laison;
    global $table_keys;
    $newTable = $laison . $table_keys;

    $dbc = connection();
    $dbc->quote($newTable);
    $dbc->quote($table_keys);
    $req = "SELECT k.idKeyword FROM $table_keys k "
            . "INNER JOIN $newTable AS mk ON mk.idKeyword = k.idKeyword WHERE mk.idMovie = :id";

    $requPrep = $dbc->prepare($req);
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();

    $data = $requPrep->fetchAll();
    $requPrep->closeCursor();
    return array_column($data, 'idKeyword');
}

function deleteAllKeywordsByMovieId($id){
    global $table_keys;
    
    $condition="WHERE idMovie = $id";
    return deleteFieldCondition($table_keys, $condition);
}