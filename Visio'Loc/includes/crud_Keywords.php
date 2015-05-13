<?php
/*
  ======Crud Keywords=======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		06/05/2015
  Version:	0.1
  Description:
 */

$table_keywords = 'keywords';

function getAllKeywords(){
    global $table_keywords;
    $cond = "ORDER BY label ASC";
    return getAllFieldsCondition($table_keywords, $cond);
}

function addKeywordsMovie($id, $keys) {
    global $movie_liaison;
    global $table_keywords;
    $newTable = $movie_liaison . $table_keywords;
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

function getKeysByMovieId($id, $type=PDO::FETCH_OBJ) {
    global $movie_liaison;
    global $table_keywords;
    $newTable = $movie_liaison . $table_keywords;

    $dbc = connection();
    $dbc->quote($newTable);
    $dbc->quote($table_keywords);
    $req = "SELECT k.idKeyword, k.label FROM $table_keywords k "
            . "INNER JOIN $newTable AS mk ON mk.idKeyword = k.idKeyword WHERE mk.idMovie = :id";

    $requPrep = $dbc->prepare($req);
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();

    $data = $requPrep->fetchAll($type);
    $requPrep->closeCursor();
    return $data;
}

function getKeysIdByMovieId($id) {
    global $movie_liaison;
    global $table_keywords;
    $newTable = $movie_liaison . $table_keywords;

    $dbc = connection();
    $dbc->quote($newTable);
    $dbc->quote($table_keywords);
    $req = "SELECT k.idKeyword FROM $table_keywords k "
            . "INNER JOIN $newTable AS mk ON mk.idKeyword = k.idKeyword WHERE mk.idMovie = :id";

    $requPrep = $dbc->prepare($req);
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();

    $data = $requPrep->fetchAll();
    $requPrep->closeCursor();
    return array_column($data, 'idKeyword');
}

function deleteAllKeywordsByMovieId($id){
    global $table_keywords;
    
    $condition="WHERE idMovie = $id";
    return deleteFieldCondition($table_keywords, $condition);
}