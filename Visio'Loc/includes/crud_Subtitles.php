<?php

/*
  ======Crud Subtitles=======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		10/05/2015
  Version:	1.0
  Description:
 */

require_once 'basics_bdd.php';

$table_sub = "subtitles";
$table_lang = "languages";

function getAllLanguages() {
    global $table_lang;
    $cond = "ORDER BY label ASC";
    return getAllFieldsCondition($table_lang, $cond);
}
/*
function getMovieSubs($id) {
    global $table_sub;
    $cond = "WHERE idMovie=$id ORDER BY idLang ASC";
    return getAllFieldsCondition($table_sub, $cond);
}*/

function getMovieSubs($idMovie) {
    global $table_sub;
    global $table_lang;
    $dbc = connection();
    $dbc->quote($table_sub);
    $dbc->quote($table_lang);
    
    $req = "SELECT * FROM $table_sub as s "
            . "INNER JOIN $table_lang as l on l.id = s.idLang "
            . "WHERE idMovie=:id "
            . "ORDER BY label ASC";
    
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':id', $idMovie, PDO::PARAM_STR);
    $requPrep->execute();
    $data = $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

function getSubtitle($idMovie, $idLang){
    global $table_sub;
    
    $cond="WHERE idMovie=$idMovie AND idLang = '$idLang'";
    return getFieldCondition($cond, $table_sub);
}

function addSubtitle($idMovie, $idLang, $src) {
    global $table_sub;

    $dbc = connection();
    $dbc->quote($table_sub);

    $req = "INSERT INTO $table_sub (idMovie, idLang, subSrc) VALUES (:idMovie, :idLang, :src)";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':idMovie', $idMovie, PDO::PARAM_STR);
    $requPrep->bindParam(':idLang', $idLang, PDO::PARAM_STR);
    $requPrep->bindParam(':src', $src, PDO::PARAM_STR);

    $requPrep->execute();
    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}

function updateSub($idMovie, $idLang, $newLang, $src) {
    global $table_sub;

    $dbc = connection();
    $dbc->quote($table_sub);

    $req = "UPDATE $table_sub SET idLang=:idLang, subSrc = :src "
            . "WHERE idMovie = :idMovie AND idLang='idLang'";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':idMovie', $idMovie, PDO::PARAM_STR);
    $requPrep->bindParam(':idLang', $newLang, PDO::PARAM_STR);
    $requPrep->bindParam(':src', $src, PDO::PARAM_STR);

    $requPrep->execute();
    $requPrep->closeCursor();
}

function deleteMovieSubs($idMovie) {
    global $table_sub;

    $cond = "WHERE idMovie = $idMovie";
    deleteFieldCondition($cond, $table_sub);
}

function deleteSub($idMovie, $idLang) {
    global $table_sub;

    $cond = "WHERE idMovie = $idMovie AND idLang = '$idLang'";
    deleteFieldCondition($cond, $table_sub);
}
