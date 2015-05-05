<?php
/*
  ======Specific functions======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		30/04/2015
  Version:	0.3
  Description:    Script regroupant les fonctions spécifiques au site web et la base de donnée
 */

session_start();
require_once 'constantes.php';

//require_once 'crud_Animal.php';

/* * isAdmin
 * Test si l'utilisateur est de type Administrateur
 * @return bool
 */
function isAdmin() {
    return ($_SESSION['usertype'] == 2);
}

/**isAccountTemp
 * Test si compte utilisateur connecté est temporaire
 * @return bool
 */
function isAccountTemp() {
    return ($_SESSION['temporary']);
}

/** isConnected
 * Test si l'utilisateur est connecté
 * @return bool
 */
function isConnected() {
    return (isset($_SESSION['id']));
}

/* * HashPerso
 * Hash le mot de passe
 * @param string $value
 * @return string
 */
function hashPerso($password, $email) {
    $derp = $password . 'SaaS';
    return sha1(md5($derp) . $email);
}

function checkImageType($fileType) {
    return in_array($fileType, unserialize(ALLOWED_IMAGE_TYPES));
}

function checkSoundType($fileType) {
    return in_array($fileType, unserialize(ALLOWED_SOUND_TYPES));
}

/** goHome
 * Redirige l'utilisateur à l'accueil
 */
function goHome() {
    header('Location: ' . ROOT_SITE . '/index.php');
}

/** redirectTempAccount
 * Redirige l'utilisateur ayant un compte temporaire sur la page de modification de mot de passe
 */
function redirectTempAccount() {
    if (isConnected() && isAccountTemp()) {
        header("Location: " . ROOT_SITE . "/user/editPassword.php");
    }
}

/** generatePassword
 * Génère un mot de passe aléatoirement
 * @param integer $length
 * @param string $chars
 * @return string
 */
function generatePassword($length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
    return substr(str_shuffle($chars), 0, $length);
}

/** getMsgTempPass
 * Retourne le message du mail de récupération de mot de passe
 * @param string $username
 * @param string $newPass
 * @return string
 */
function getMsgTempPass($username, $newPass) {
    return "Bonjour $username, \r\n" .
            "La réinitialisation de mot de passe pour votre compte sur notre site Visio'Loc a été accompli\r\n" .
            "Votre nouveau mot de passe est: $newPass.\r\n" .
            "Ceci n'est qu'un mot de passe temporaire, vous devrez le modifier une fois connecté.\r\n" .
            "Coridialement\r\n" .
            "L'équipe Visio'Loc";
}

/* * debug
 * affiche de façon formatté une variable 
 * @param string $sObj
 */
function debug($sObj = NULL) {
    echo '<pre>';
    if (is_null($sObj)) {
        echo '|Object is NULL|' . "\n";
    } elseif (is_array($sObj) || is_object($sObj)) {
        var_dump($sObj);
    } else {
        echo '|' . $sObj . '|' . "\n";
    }
    echo '</pre>';
}
