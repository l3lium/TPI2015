<?php
/*
  ======Specific functions======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		29/04/2015
  Version:	0.2
  Description:    Script regroupant les fonctions spécifiques au site web et la base de donnée
 */

session_start();
require_once 'crud_User.php';
//require_once 'crud_Animal.php';

/* * isAdmin
 * Test si l'utilisateur est de type Administrateur
 * @return bool
 */
function isAdmin() {
    return ($_SESSION['usertype'] == 2);
}

/* * isConnected
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
function hashPerso($password, $username) {
    $derp = $password . 'SaaS';
    return sha1(md5($derp) + $username);
}

function checkImageType($fileType) {
    return in_array($fileType, unserialize(ALLOWED_IMAGE_TYPES));
}

function checkSoundType($fileType) {
    return in_array($fileType, unserialize(ALLOWED_SOUND_TYPES));
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
