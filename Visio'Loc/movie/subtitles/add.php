<?php
require_once '../../includes/specific_funtions.php';
require_once '../../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isAdmin()) {
    goHome();
}

//TEST des parametres
if (filter_input(INPUT_POST, 'addSub')) {
    $valide = true;
    $erreur = "";
    $idMovie = filter_input(INPUT_POST, "idMovie");
    $idLang = filter_input(INPUT_POST, "lang");
    $src = filter_input(INPUT_POST, "srcSub");
    if (!$movie = getMovieById($idMovie)) {
        goHome();
    }

    if (!$idMovie) {
        $valide = FALSE;
        $erreur = 'Le film n\'est pas valide.';
    } elseif (!$idLang) {
        $valide = FALSE;
        $erreur = 'La langue n\'est pas valide.';
    } elseif (!$src) {
        $valide = FALSE;
        $erreur = 'Le sous-titre n\'as pas été envoyé.';
    }

    if ($valide) {
        addSubtitle($idMovie, $idLang, $src);
    }
}
header("location: manage.php?id=$idMovie");
