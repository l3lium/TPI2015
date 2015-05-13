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
$table_liaison = 'users_has_movies';

/** createUser
 * Crée un utilisateur dans la base de données
 * @global string $table
 * @param string $email
 * @param string $username
 * @param string $password
 * @return int l'id de l'élément ajouté
 */
function createUser($email, $username) {
    global $table;
    //Hashage du mot de passe
    //$password=hashPerso($password, $email);

    $dbc = connection();
    $dbc->quote($table);

    $req = "INSERT INTO $table (email, username) VALUES (:email, :username)";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':email', $email, PDO::PARAM_STR);
    $requPrep->bindParam(':username', $username, PDO::PARAM_STR);
    //$requPrep->bindParam(':password', $password, PDO::PARAM_STR);
    $requPrep->execute();
    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}

/** getConnectedUser
 * Retroune les champs de l'utilisateur connecté
 * @return PDO::FETCH_OBJ
 */
function getConnectedUser() {
    $id = $_SESSION["id"];
    return getUserById($id);
}

/** updateActualUsername
 * Met à jour le nom de l'utilisateur connecté
 * @param string $newUsername
 */
function updateActualUsername($newUsername) {
    $id = $_SESSION["id"];
    updateUsernameById($id, $newUsername);
    setSessionUser(getUserById($id));
}

/** updateActualUserPassword
 * Met à jour le mot de passe de l'utilisateur connecté
 * @param string $password
 */
function updateActualUserPassword($password, $temp = false) {
    $id = $_SESSION["id"];
    updatePasswordById($id, $password, $temp);
    setSessionUser(getUserById($id));
}

/** updateUsernameById
 * Met à jour le nom de l'utilisateur grâce à l'id
 * @global string $table
 * @param int $id
 * @param string $newUsername
 */
function updateUsernameById($id, $newUsername) {
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
function updatePasswordById($id, $newPassword, $temp = false) {
    global $table;
    
    $dbc = connection();
    $dbc->quote($table);
    $req = "UPDATE $table SET password = :password, temporary = :temp "
            . "WHERE id = :id";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':password', $newPassword, PDO::PARAM_STR);
    $requPrep->bindParam(':temp', $temp, PDO::PARAM_STR);
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
function updateUserById($id, $newUsername, $newEmail) {
    global $table;

    $dbc = connection();
    $dbc->quote($table);
    $req = "UPDATE $table SET username = :username, email = :email "
            . "WHERE id = :id";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $requPrep->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $requPrep->bindParam(':id', $id, PDO::PARAM_STR);
    $requPrep->execute();
    $requPrep->closeCursor();
}

function updateUserConnected($newUsername, $newEmail) {
    $id = $_SESSION['id'];
    updateUserById($id, $newUsername, $newEmail);
    setSessionUser(getUserById($id));
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
    $data = $requPrep->fetch(PDO::FETCH_OBJ);
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
    $data = $requPrep->fetch(PDO::FETCH_OBJ);
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
    $_SESSION['email'] = $email;
    $user = getUserbyEmail($email);
    
    if ($user != NULL && $user->password === hashPerso($password, $user->id)) {
        setSessionUser($user);
        $connect = TRUE;
    }
    return $connect;
}

/** setSessionUser
 * Ajoute les informations de l'utilisateur connecté en session
 * @param PDO::FETCH_OBJ $user
 */
function setSessionUser($user) {
    if (isset($user)) {
        $_SESSION['id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['temporary'] = $user->temporary;
        $_SESSION['usertype'] = $user->userType;
    }
}

function isMovieBuy($idMovie) {
    global $table_liaison;
    $idUser = $_SESSION['id'];

    $cond = "WHERE rent = 0 AND idUser = $idUser AND idMovie = $idMovie";
    return countFieldsCondition($table_liaison, $cond);
}

function getMoviesBuy() {
    global $table_liaison;
    global $table_movies;

    $dbc = connection();
    $dbc->quote($table_liaison);
    $dbc->quote($table_movies);

    $req = "SELECT m.id, m.title, m.date, m.imgSrc,  m.videoSrc, m.synopsis, "
            . "um.rent "
            . "FROM $table_movies as m "
            . "INNER JOIN $table_liaison as um on um.idMovie = m.id "
            . "WHERE um.idUser=:idUser AND um.rent=0";

    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':idUser', $_SESSION["id"], PDO::PARAM_INT);
    $requPrep->execute();
    $data = $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

function getMoviesRent() {
    global $table_liaison;
    global $table_movies;

    $dbc = connection();
    $dbc->quote($table_liaison);
    $dbc->quote($table_movies);

    $req = "SELECT m.id, m.title, m.date, m.imgSrc,  m.videoSrc, m.synopsis, "
            . "NOW() < DATE_ADD(timestamp, INTERVAL " . RENT_HOUR . " HOUR) as valide,"
            . "um.rent, TIMEDIFF(DATE_ADD(timestamp, INTERVAL " . RENT_HOUR . " HOUR), NOW()) as timeLeft  "
            . "FROM $table_movies as m "
            . "INNER JOIN $table_liaison as um on um.idMovie = m.id "
            . "WHERE um.idUser=:idUser AND um.rent=1 "
            . "ORDER BY um.timestamp DESC";

    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':idUser', $_SESSION["id"], PDO::PARAM_INT);
    $requPrep->execute();
    $data = $requPrep->fetchAll(PDO::FETCH_OBJ);
    $requPrep->closeCursor();
    return $data;
}

function isMovieRentValide($idMovie) {
    global $table_liaison;
    $idUser = $_SESSION['id'];

    $cond = "WHERE rent = 1 AND idUser=$idUser AND idMovie=$idMovie AND"
            . " NOW() < DATE_ADD(timestamp, INTERVAL " . RENT_HOUR . " HOUR)";
    return countFieldsCondition($table_liaison, $cond);
}

function buyMovie($idMovie) {
    $id = $_SESSION['id'];
    return userGetMovie($id, $idMovie, false);
}

function rentMovie($idMovie) {
    $id = $_SESSION['id'];
    return userGetMovie($id, $idMovie, true);
}

function userGetMovie($idUser, $idMovie, $type) {
    global $table_liaison;

    $dbc = connection();
    $dbc->quote($table_liaison);

    $req = "INSERT INTO $table_liaison (idUser, idMovie, rent) "
            . "VALUES (:idUser, :idMovie, :rent)";
    $requPrep = $dbc->prepare($req); // on prépare notre requête
    $requPrep->bindParam(':idUser', $idUser, PDO::PARAM_STR);
    $requPrep->bindParam(':idMovie', $idMovie, PDO::PARAM_STR);
    $requPrep->bindParam(':rent', $type, PDO::PARAM_BOOL);
    $requPrep->execute();
    $requPrep->closeCursor();
    return $dbc->lastInsertId();
}
