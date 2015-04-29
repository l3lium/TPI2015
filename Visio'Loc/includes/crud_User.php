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

/** createUser
 * Crée un utilisateur dans la base de données
 * @global string $table
 * @param string $email
 * @param string $username
 * @param string $password
 * @return int l'id de l'élément ajouté
 */
function createUser($email, $username, $password){
    global $table;
    //Hashage du mot de passe
    $password=hashPerso($password, $username);
    
    $dbc = connection();
    $dbc->quote($table);
    
    $req = "INSERT INTO $table (email, username, password) VALUES (:email, :username, :password, 1)";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':email', $email, PDO::PARAM_STR);
    $requPrep->bindParam(':username', $username, PDO::PARAM_STR);
    $requPrep->bindParam(':password', $password, PDO::PARAM_STR);
    $requPrep->execute();
    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}

/** getConnectedUser
 * Retroune les champs de l'utilisateur connecté
 * @return PDO::FETCH_OBJ
 */
function getConnectedUser()
{
    $id = $_SESSION["id"];
    return getUserById($id);
}

/** updateActualUsername
 * Met à jour le nom de l'utilisateur connecté
 * @param string $newUsername
 */
function updateActualUsername($newUsername)
{
    $id = $_SESSION["id"];
    updateUsernameById($id, $newUsername);
    setSessionUser(getUserById($id));
}

/** updateActualUserPassword
 * Met à jour le mot de passe de l'utilisateur connecté
 * @param string $password
 */
function updateActualUserPassword($password)
{
    $id = $_SESSION["id"];
    updatePasswordById($id, $password);
}

/** updateUsernameById
 * Met à jour le nom de l'utilisateur grâce à l'id
 * @global string $table
 * @param int $id
 * @param string $newUsername
 */
function updateUsernameById($id, $newUsername){
    global $table;
    
    $dbc = connection();
    $dbc->quote($table);
    $req = "UPDATE $table SET username = :username WHERE id = :id";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $requPrep->bindParam(':id', $id, PDO::PARAM_STR);
    $requPrep->execute();
    $requPrep->closeCursor();
}

/** updatePasswordById
 * Met à jour le mo de passe de l'utilisateur grâce à l'id
 * @global string $table
 * @param int $id
 * @param string $newPassword
 */
function updatePasswordById($id, $newPassword){
    global $table;
    
    $dbc = connection();
    $dbc->quote($table);
    $req = "UPDATE $table SET password = :password WHERE id = :id";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':password', $newPassword, PDO::PARAM_STR);
    $requPrep->bindParam(':id', $id, PDO::PARAM_STR);
    $requPrep->execute();
    $requPrep->closeCursor();
}

/** updateUserById
 * Met à jour les champs username et password de l'utilisateur
 * @global string $table
 * @param string $newUsername
 * @param string $newPassword
 */
function updateUserById($newUsername, $newPassword){
    global $table;
    
    $dbc = connection();
    $dbc->quote($table);
    $req = "UPDATE $table SET username = :username WHERE id = :id";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $requPrep->bindParam(':id', $id, PDO::PARAM_STR);
    $requPrep->execute();
    $requPrep->closeCursor();
}

/** getUserById
 * récupère un utilisateur grâce à l'id
 * @global string $table
 * @param int $id
 * @return PDO::FETCH_OBJ
 */
function getUserById($id) {
    global $table;

    return getFieldById($id, $table);
}

/** getUserByUsername
 * récupère un utilisateur grâce à son nom
 * @global string $table
 * @param type $username
 * @return PDO::FETCH_OBJ
 */
function getUserByUsername($username) {
    global $table;
    $dbc = connection();
    $dbc->quote($table);
    
    $req = "SELECT * FROM $table WHERE username=:username";
    // preparation de la requete
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':username', $username, PDO::PARAM_STR);
    $requPrep->execute();
    $data= $requPrep->fetch(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

/** getUserByEmail
 * récupère un utilisateur grâce à l'email
 * @global string $table
 * @param type $mail
 * @return PDO::FETCH_OBJ
 */
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

/** userConnect
 * Connecte l'utilisateur
 * @param string $email
 * @param string $password
 * @return boolean
 */
function userConnect($email, $password) {
    $connect = false;
    $_SESSION['email']= $email;
    $user = getUserbyEmail($email);
    if ($user != NULL && $user->password === hashPerso($password, $email)) {
        setSessionUser($user);
        $connect = TRUE;
    }
    return $connect;
}

/** setSessionUser
 * Ajoute les informations de l'utilisateur connecté en session
 * @param PDO::FETCH_OBJ $user
 */
function setSessionUser($user)
{
    if (isset($user))
    {
        $_SESSION['id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['usertype'] = $user->userType;
    }
}