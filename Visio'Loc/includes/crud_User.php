<?php
/*
======Crud User=======
Auteur: 	Oliveira Stéphane
Classe: 	I.IN-P4B
Date:		29/04/2015
Version:	1.0
Description:    Script contenant les fonctions en relation avec le 
                l'identification et le crud user (create, read, update, delete)
*/

require_once 'basics_bdd.php';

$table = 'users';

function createUser($email, $username, $password){
    global $table;
    //Hashage du mot de passe
    $password=hashPerso($password, $username);
    
    $dbc = connection();
    $dbc->quote($table);
    
    $req = "INSERT INTO $table (email, username, password) VALUES (:email, :username, :password)";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':email', $email, PDO::PARAM_STR);
    $requPrep->bindParam(':username', $username, PDO::PARAM_STR);
    $requPrep->bindParam(':password', $password, PDO::PARAM_STR);
    $requPrep->execute();
    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}

function getUserByPseudo($pseudo) {
    global $table;
    $dbc = connection();
    $dbc->quote($table);
    
    $req = "SELECT * FROM $table WHERE username=:pseudo";
    // preparation de la requete
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $requPrep->execute();
    $data= $requPrep->fetch(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

function getUserByEmail($mail) {
    global $table;
    $dbc = connection();
    $dbc->quote($table);
    
    $req = "SELECT * FROM $table WHERE email=:mail";
    // preparation de la requete
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':mail', $mail, PDO::PARAM_STR);
    $requPrep->execute();
    $data= $requPrep->fetch(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

function userConnect($email, $password) {
    $connect = false;
    $_SESSION['email']= $email;
    $user = getUserbyEmail($email);
    if ($user != NULL && $user->password === hashPerso($password, $email)) {
        $_SESSION['id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $email;
        $_SESSION['usertype'] = $user->userType;
        $connect = TRUE;
    }
    return $connect;
}