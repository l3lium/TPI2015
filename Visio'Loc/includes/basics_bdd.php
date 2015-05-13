<?php
/*
======Basic Bdd=======
Auteur: 	Oliveira Stéphane
Classe: 	I.IN-P4B
Date:		29/04/2015
Version:	0.3
Description:    Script contenant les fonctions basiques relative à la base de donnée
                    - connexion base de donnée (PDO)
                    - retourne le nombre d'enregistrement dans la table donnée
                    - retourne un enregistrement par rapport à l'id
                    - retourne tout les enregistrements d'une table donnée
                    - retourne un nombre défini d'enregistrements pour la pagination
                    - supprime un enregistrement de la table donnée par rapport à l'id
*/

require_once 'constantes.php';

/** connection
 * Fonction qui retourne une connexion PDO à une base de donnée mysql ou une erreur.
 * @return PDO
 */
function connection() {
    try {
        $bdd = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_LOGIN,
                DB_PASS, array(PDO::ATTR_PERSISTENT => true));
        
        return $bdd;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

/** countFields
 * Fonction qui retourne le nombre total d'enregistrement d'une table 
 * passée en paramètre
 * @param $table string 
 * @return Integer
 */
function countFields($table) {
    $dbc = connection();
    $dbc->quote($table);
    $req = "SELECT COUNT(*) FROM $table";
    
    $requPrep = $dbc->prepare($req);
    $requPrep->execute();
    
    $number=$requPrep->fetch();
    $requPrep->closeCursor();
    return $number[0];
}

/** countFieldsCondition
 * Fonction qui retourne le nombre total d'enregistrement d'une table selon une 
 * condition passée en parametre
 * @param string $table
 * @param string $condition
 * @return type
 */
function countFieldsCondition($table, $condition) {
    $dbc = connection();
    $dbc->quote($table);
    $dbc->quote($condition);
    $req = "SELECT COUNT(*) FROM $table $condition";
    
    $requPrep = $dbc->prepare($req);
    $requPrep->execute();
    
    $number=$requPrep->fetch();
    $requPrep->closeCursor();
    return $number[0];
}

/** getFieldById
 * Cette fonction récupère un enregistrement de la table donnée en paramètre grâce à 
 * l'id également donnée en paramètre
 * @param Integer $id
 * @param String $table
 * @return PDO::FETCH_OBJ
 */
function getFieldById($id, $table){
    $dbc = connection();
    $dbc->quote($table);
    $req = "SELECT * FROM $table WHERE id=:id";
    // preparation de la requete
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();

    return $requPrep->fetch(PDO::FETCH_OBJ);
}

/** getFieldCondition
 * Retourne un enregistrement selon une condition et une table
 * @param string $table le nom de la table
 * @param string $condition la condition
 * @return PDO::FETCH_OBJ résultat de la requette
 */
function getFieldCondition($condition, $table){
    $dbc = connection();
    $dbc->quote($table);
    $dbc->quote($condition);
    $req = "SELECT * FROM $table $condition";
    // preparation de la requete
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->execute();

    return $requPrep->fetch(PDO::FETCH_OBJ);
}

/** getAllFields
 * Cette fonction retourne tous les enregistrements de la table passée en paramètre
 * @param String $table
 * @return PDO::FETCH_OBJ résultat de la requette
 */
function getAllFields($table){
    $dbc= connection();
    $dbc->quote($table);
    $req = "SELECT * FROM $table";
	
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->execute();
    $data= $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

/** getAllFieldsCondition
 * Retourne tous les enregistrements selon une table et une condition
 * @param string $table le nom de la table
 * @param string $condition la condition
 * @return PDO::FETCH_OBJ résultat de la requette
 */
function getAllFieldsCondition($table, $condition){
    $dbc = connection();
    $dbc->quote($table);
    $dbc->quote($condition);
    $req = "SELECT * FROM $table $condition";
    
    $requPrep = $dbc->prepare($req);
    $requPrep->execute();
    
    $data= $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

/** getPaginationQuerry
 * Retourne la liste des enregistrement d'une page donnée en paramètre selon la 
 * requette egalement passée en parametre 
 * @param Integer $page
 * @param Integer $nbRow
 * @param String $table
 * @return PDO::FETCH_OBJ résultat de la requette
 */
function getPaginationQuerry($page = 1, $nbRow = 0, $query) {
    $dbc = connection();
    $offset= ($page-1)*$nbRow;

    $req = $query." LIMIT :offset , :max ";//Ajout de la limite pour la pagination
    // preparation de la requete
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':offset', $offset, PDO::PARAM_INT);
    $requPrep->bindParam(':max', $nbRow, PDO::PARAM_INT);
    
    $requPrep->execute();
    $clients = $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $clients;
}

/** getFieldsPagination
 * Retourne la liste des enregistrement d'une page donnée en paramètre selon la 
 * table egalement passée en parametre 
 * @param Integer $page
 * @param Integer $nbRow
 * @param String $table
 * @return PDO::FETCH_OBJ résultat de la requette
 */
function getFieldsPagination($page = 1, $nbRow = 0, $table) {
    $dbc = connection();
    $dbc->quote($table);
    $offset= ($page-1)*$nbRow;
    
    $req = "SELECT * FROM $table LIMIT :offset , :max ";//Ajout de la limite pour la pagination
    // preparation de la requete
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':offset', $offset, PDO::PARAM_INT);
    $requPrep->bindParam(':max', $nbRow, PDO::PARAM_INT);  
    $requPrep->execute();
    $clients = $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $clients;
}

/** deleteFieldById
 * Cette fonction supprime un enregistrement de la table donnée en paramètre grâce à 
 * l'id également donnée en paramètre
 * @param Integer $id
 * @param String $table résultat de la requette
 */
function deleteFieldById($id, $table){
    $dbc= connection();
    $dbc->quote($table);
    $req = "DELETE FROM $table WHERE id=:id";

    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':id', $id, PDO::PARAM_INT);
    $requPrep->execute();
    $data= $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
}

/** deleteFieldById
 * Cette fonction supprime un enregistrement de la table donnée en paramètre grâce à 
 * l'id également donnée en paramètre
 * @param Integer $id
 * @param String $table résultat de la requette
 */
function deleteFieldCondition($condition, $table){
    $dbc= connection();
    $dbc->quote($table);
    $dbc->quote($condition);
    $req = "DELETE FROM $table $condition";

    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->execute();
    $data= $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}