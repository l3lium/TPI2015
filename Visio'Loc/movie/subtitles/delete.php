<?php

require_once '../../includes/specific_funtions.php';
require_once '../../includes/crud_Movies.php';

//TEST des parametres
if (filter_input(INPUT_POST, 'delete')) {
    $idMovie = filter_input(INPUT_POST, 'idMovie');
    $idLang = filter_input(INPUT_POST, 'idLang');

    if ($sub = getSubtitle($idMovie, $idLang)) {
        deleteSub($idMovie, $idLang);
        debug($sub);
        $subFile = $_SERVER["DOCUMENT_ROOT"] . $sub->subSrc;
        debug($subFile);
        if (file_exists($subFile)) {
            unlink($subFile);
        }
    }
}

header("location: manage.php?id=$idMovie");